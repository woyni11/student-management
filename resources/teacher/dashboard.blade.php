@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')

    <h3 class="mb-4">Welcome, {{ auth()->user()->name }}</h3>

    <h5>My Courses</h5>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Course</th><th>Code</th><th>Students Enrolled</th></tr></thead>
                <tbody>
                    @forelse ($teacher->courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->students->count() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No courses assigned yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary me-2">Take Attendance</a>
        <a href="{{ route('teacher.grades.create') }}" class="btn btn-success">Enter Grades</a>
    </div>

@endsection
