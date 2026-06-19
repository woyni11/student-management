@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')

    <h3 class="mb-1">Attendance Report</h3>
    <p class="text-muted">{{ $course->name }} ({{ $course->code }})</p>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Student</th><th>Email</th><th>Attendance Rate</th></tr></thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $student->attendance_percentage >= 75 ? 'success' : 'danger' }}">
                                    {{ $student->attendance_percentage }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No students enrolled.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary mt-3">Back to Reports</a>

@endsection
