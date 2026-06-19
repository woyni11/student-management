<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $students = Student::with(['user', 'courses'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.students.index', compact('students', 'search'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();

        return view('admin.students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStudent($request);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            $student = $user->student()->create([
                'phone' => $validated['phone'],
                'dob' => $validated['dob'],
                'address' => $validated['address'] ?? null,
                'status' => $validated['status'],
            ]);

            $student->courses()->sync($validated['course_ids'] ?? []);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'courses', 'attendances.course', 'grades.course']);

        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load(['user', 'courses']);
        $courses = Course::orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $this->validateStudent($request, $student->user_id);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (! empty($validated['password'])) {
                $student->user->update(['password' => Hash::make($validated['password'])]);
            }

            $student->update([
                'phone' => $validated['phone'],
                'dob' => $validated['dob'],
                'address' => $validated['address'] ?? null,
                'status' => $validated['status'],
            ]);

            $student->courses()->sync($validated['course_ids'] ?? []);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Deleting the user cascades and deletes the linked student row too.
        $student->user->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    private function validateStudent(Request $request, $ignoreUserId = null): array
    {
        $passwordRule = $ignoreUserId ? ['nullable', 'string', 'min:6'] : ['required', 'string', 'min:6'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignoreUserId)],
            'password' => $passwordRule,
            'phone' => ['required', 'string', 'max:20'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id'],
            'dob' => ['required', 'date'],
            'address' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}
