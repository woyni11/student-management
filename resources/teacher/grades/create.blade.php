@extends('layouts.app')

@section('title', 'Enter Grades')

@section('content')

    <h3 class="mb-3">Enter Grades</h3>

    <form method="GET" action="{{ route('teacher.grades.create') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <select name="course_id" class="form-select" onchange="this.form.submit()">
                @foreach ($courses as $c)
                    <option value="{{ $c->id }}" {{ ($course?->id ?? null) === $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->code }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if ($course)
        <form action="{{ route('teacher.grades.store') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <div class="mb-3 col-md-5">
                <label class="form-label">Assessment Name</label>
                <input type="text" name="assessment" class="form-control" placeholder="e.g. Midterm Exam" required>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Student</th><th style="width:140px;">Score (0-100)</th><th>Remarks</th></tr></thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->user->name }}</td>
                                    <td>
                                        <input type="number" step="0.01" min="0" max="100" name="scores[{{ $student->id }}]" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="remarks[{{ $student->id }}]" class="form-control form-control-sm">
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
                <button type="submit" class="btn btn-primary mt-3">Save Grades</button>
            @endif
        </form>
    @else
        <p class="text-muted">You have no assigned courses yet.</p>
    @endif

@endsection
