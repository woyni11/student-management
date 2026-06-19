@extends('layouts.app')

@section('title', 'Take Attendance')

@section('content')

    <h3 class="mb-3">Take Attendance</h3>

    <form method="GET" action="{{ route('teacher.attendance.create') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <select name="course_id" class="form-select" onchange="this.form.submit()">
                @foreach ($courses as $c)
                    <option value="{{ $c->id }}" {{ (int) $courseId === $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->code }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
        </div>
    </form>

    @if ($course)
        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Student</th><th>Present</th><th>Absent</th></tr></thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->user->name }}</td>
                                    <td>
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="present" checked>
                                    </td>
                                    <td>
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="absent">
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4">No students enrolled in this course.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($students->isNotEmpty())
                <button type="submit" class="btn btn-primary mt-3">Save Attendance</button>
            @endif
        </form>
    @else
        <p class="text-muted">You have no assigned courses yet.</p>
    @endif

@endsection
