@extends('layouts.app')

@section('title', 'Grades')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Grades</h3>
        <a href="{{ route('teacher.grades.create') }}" class="btn btn-primary">+ Enter Grades</a>
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
                <thead><tr><th>Student</th><th>Course</th><th>Assessment</th><th>Score</th><th>Remarks</th></tr></thead>
                <tbody>
                    @forelse ($grades as $g)
                        <tr>
                            <td>{{ $g->student->user->name }}</td>
                            <td>{{ $g->course->name }}</td>
                            <td>{{ $g->assessment }}</td>
                            <td>{{ $g->score }}</td>
                            <td>{{ $g->remarks ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">No grades recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $grades->links() }}</div>

@endsection
