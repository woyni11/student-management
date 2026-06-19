<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher.user')->withCount('students')->latest()->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $this->validateCourse($request, $course->id);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    private function validateCourse(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('courses', 'code')->ignore($ignoreId)],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);
    }
}
