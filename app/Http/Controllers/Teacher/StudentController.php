<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show only the students enrolled in at least one of this teacher's courses.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $courseIds = $teacher->courses()->pluck('id');

        $students = Student::with(['user', 'courses'])
            ->whereHas('courses', function ($query) use ($courseIds) {
                $query->whereIn('courses.id', $courseIds);
            })
            ->latest()
            ->paginate(10);

        return view('teacher.students.index', compact('students'));
    }
}
