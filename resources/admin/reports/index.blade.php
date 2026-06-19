@extends('layouts.app')

@section('title', 'Reports')

@section('content')

    <h3 class="mb-3">Reports</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr><th>Course</th><th>Students</th><th class="text-end">Reports</th></tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>{{ $course->name }} ({{ $course->code }})</td>
                            <td>{{ $course->students_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.reports.attendance', $course) }}" class="btn btn-sm btn-info">Attendance Report</a>
                                <a href="{{ route('admin.reports.grades', $course) }}" class="btn btn-sm btn-secondary">Grades Report</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No courses yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
