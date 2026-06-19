<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;

class ReportController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('students')->orderBy('name')->get();

        return view('admin.reports.index', compact('courses'));
    }

    public function attendance(Course $course)
    {
        $students = $course->students()->with('user')->get()->map(function ($student) {
            $student->attendance_percentage = $student->attendancePercentage();

            return $student;
        });

        return view('admin.reports.attendance', compact('course', 'students'));
    }

    public function grades(Course $course)
    {
        $students = $course->students()->with(['user', 'grades' => function ($q) use ($course) {
            $q->where('course_id', $course->id);
        }])->get();

        return view('admin.reports.grades', compact('course', 'students'));
    }
}
