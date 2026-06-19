<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $teacher  = Auth::user()->teacher;
        $courses  = $teacher->courses;
        $courseId = (int) $request->query('course_id', $courses->first()?->id);
        $course   = $courses->firstWhere('id', $courseId);

        $assessments = array_keys(Grade::WEIGHTS);

        // Build one summary row per student for the view.
        $studentGrades = [];

        if ($course) {
            $students = $course->students()->with('user')->get();

            // Load all grades for this course keyed by [student_id][assessment]
            $gradeMap = Grade::where('course_id', $courseId)
                ->get()
                ->groupBy('student_id')
                ->map(fn ($rows) => $rows->keyBy('assessment'));

            foreach ($students as $student) {
                $scores = [];
                $total  = 0;

                foreach (Grade::WEIGHTS as $name => $max) {
                    $g = $gradeMap[$student->id][$name] ?? null;
                    if ($g) {
                        $scores[$name] = [
                            'score'  => $g->score,
                            'remark' => $g->remarks,
                        ];
                        $total += (float) $g->score;
                    }
                }

                $studentGrades[] = [
                    'id'     => $student->id,
                    'name'   => $student->user->name,
                    'scores' => $scores,
                    'total'  => $total,
                    'grade'  => Grade::remark($total),
                ];
            }
        }

        return view('teacher.grades.index', compact('courses', 'courseId', 'studentGrades'));
    }

    public function create(Request $request)
    {
        $teacher  = Auth::user()->teacher;
        $courses  = $teacher->courses;
        $courseId = (int) $request->query('course_id', $courses->first()?->id);
        $course   = $courses->firstWhere('id', $courseId);
        $students = $course ? $course->students()->with('user')->get() : collect();

        // Pre-fill existing grades so the form shows current values.
        $existingGrades = [];
        if ($course) {
            Grade::where('course_id', $courseId)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->each(function ($g) use (&$existingGrades) {
                    $existingGrades[$g->student_id][$g->assessment] = $g;
                });
        }

        return view('teacher.grades.create', compact('courses', 'course', 'students', 'courseId', 'existingGrades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'grades'    => ['required', 'array'],
        ]);

        $teacher = Auth::user()->teacher;
        abort_unless($teacher->courses()->where('id', $request->input('course_id'))->exists(), 403);

        $courseId    = $request->input('course_id');
        $gradesInput = $request->input('grades', []);

        foreach ($gradesInput as $studentId => $assessments) {
            foreach (Grade::WEIGHTS as $name => $max) {
                $entry = $assessments[$name] ?? null;
                $score = $entry['score'] ?? null;

                if ($score === null || $score === '') {
                    continue;
                }

                // Clamp to max silently (controller-level safety on top of HTML max).
                $score = min((float) $score, $max);

                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_id'  => $courseId,
                        'assessment' => $name,
                    ],
                    [
                        'score'   => $score,
                        'remarks' => $entry['remark'] ?? null,
                    ]
                );
            }
        }

        return redirect()
            ->route('teacher.grades.index', ['course_id' => $courseId])
            ->with('success', 'Grades saved successfully.');
    }

    public function edit(Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        abort_unless($teacher->courses()->where('id', $grade->course_id)->exists(), 403);

        return view('teacher.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        abort_unless($teacher->courses()->where('id', $grade->course_id)->exists(), 403);

        $maxScore = Grade::WEIGHTS[$grade->assessment];

        $validated = $request->validate([
            'score'   => ['required', 'numeric', 'min:0', "max:{$maxScore}"],
            'remarks' => ['nullable', 'string'],
        ]);

        $grade->update($validated);

        return redirect()
            ->route('teacher.grades.index', ['course_id' => $grade->course_id])
            ->with('success', 'Grade updated successfully.');
    }
}
