<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function profile()
    {
        $student = Auth::user()->student()->with(['courses.teacher.user'])->first();
        return view('student.profile', compact('student'));
    }

    public function courses()
    {
        $student = Auth::user()->student()->with(['courses.teacher.user'])->first();
        return view('student.courses', compact('student'));
    }

    public function attendance()
    {
        $student = Auth::user()->student;
        $records = $student->attendances()->with('course')->latest('date')->paginate(15);
        $percentage = $student->attendancePercentage();
        return view('student.attendance', compact('records', 'percentage'));
    }

    public function grades()
    {
        $student = Auth::user()->student;

        $allGrades = $student->grades()->with('course')->get();

        $gradesByCourse = $allGrades->groupBy('course_id')->map(function ($grades) {
            $course = $grades->first()->course;
            $total  = $grades->sum(fn($g) => (float) $g->score);
            $remark = Grade::remark($total);
            return [
                'course'  => $course,
                'grades'  => $grades,
                'total'   => $total,
                'remark'  => $remark,
            ];
        });

        $maxTotal = array_sum(Grade::WEIGHTS);

        return view('student.grades', compact('gradesByCourse', 'maxTotal'));
    }
}