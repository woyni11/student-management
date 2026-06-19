@extends('layouts.app')

@section('title', 'Student Details')

@section('content')

    <h3 class="mb-3">Student Details</h3>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table">
                <tr><th style="width:200px;">Name</th><td>{{ $student->user->name }}</td></tr>
                <tr><th>Email</th><td>{{ $student->user->email }}</td></tr>
                <tr><th>Phone</th><td>{{ $student->phone }}</td></tr>
                <tr><th>Courses</th><td>
                    @forelse ($student->courses as $c)
                        <span class="badge bg-secondary">{{ $c->name }} ({{ $c->code }})</span>
                    @empty
                        — not enrolled in any course —
                    @endforelse
                </td></tr>
                <tr><th>Date of Birth</th><td>{{ $student->dob?->format('d M, Y') }}</td></tr>
                <tr><th>Address</th><td>{{ $student->address ?: '—' }}</td></tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($student->status) }}</span></td>
                </tr>
                <tr><th>Attendance Rate</th><td>{{ $student->attendancePercentage() }}%</td></tr>
            </table>
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5>Recent Attendance</h5>
            <table class="table table-sm table-striped">
                <thead><tr><th>Date</th><th>Course</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($student->attendances as $a)
                        <tr>
                            <td>{{ $a->date->format('d M, Y') }}</td>
                            <td>{{ $a->course->name }}</td>
                            <td>{{ ucfirst($a->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h5>Grades</h5>
            <table class="table table-sm table-striped">
                <thead><tr><th>Course</th><th>Assessment</th><th>Score</th></tr></thead>
                <tbody>
                    @forelse ($student->grades as $g)
                        <tr>
                            <td>{{ $g->course->name }}</td>
                            <td>{{ $g->assessment }}</td>
                            <td>{{ $g->score }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No grades yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
