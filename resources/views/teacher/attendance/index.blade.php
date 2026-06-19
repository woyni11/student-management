@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Attendance Records</h3>
        <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary">+ Take Attendance</a>
    </div>

    <form method="GET" class="mb-3 col-md-4">
        <select name="course_id" class="form-select" onchange="this.form.submit()">
            @foreach ($courses as $c)
                <option value="{{ $c->id }}" {{ $courseId === $c->id ? 'selected' : '' }}>
                    {{ $c->name }} ({{ $c->code }})
                </option>
            @endforeach
        </select>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Date</th><th>Student</th><th>Course</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($records as $r)
                        <tr>
                            <td>{{ $r->date->format('d M, Y') }}</td>
                            <td>{{ $r->student->user->name }}</td>
                            <td>{{ $r->course->name }}</td>
                            <td>
                                <span class="badge bg-{{ $r->status === 'present' ? 'success' : 'danger' }}">{{ ucfirst($r->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">No attendance recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $records->links() }}</div>

@endsection
