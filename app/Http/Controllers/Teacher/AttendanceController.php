<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $courses = $teacher->courses;

        $courseId = (int) $request->query('course_id', $courses->first()?->id);

        $records = Attendance::with(['student.user', 'course'])
            ->when($courseId, fn ($q) => $q->where('course_id', $courseId))
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        return view('teacher.attendance.index', compact('courses', 'records', 'courseId'));
    }

    public function create(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $courses = $teacher->courses;

        $courseId = (int) $request->query('course_id', $courses->first()?->id);
        $course = $courses->firstWhere('id', $courseId);

        $students = $course ? $course->students()->with('user')->get() : collect();
        $date = $request->query('date', now()->format('Y-m-d'));

      return view('teacher.attendance.create', compact('courses', 'course', 'students', 'date', 'courseId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'in:present,absent'],
        ]);

        // Make sure this teacher actually owns the course being marked.
        $teacher = Auth::user()->teacher;
        abort_unless($teacher->courses()->where('id', $validated['course_id'])->exists(), 403);

        foreach ($validated['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $validated['course_id'],
                    'date' => $validated['date'],
                ],
                ['status' => $status]
            );
        }

        return redirect()
            ->route('teacher.attendance.index', ['course_id' => $validated['course_id']])
            ->with('success', 'Attendance saved successfully.');
    }
}
