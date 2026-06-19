@extends('layouts.app')

@section('title', 'Enter Grades')

@section('content')

    <h3 class="mb-3">Enter Grades</h3>

    {{-- Course selector --}}
    <form method="GET" action="{{ route('teacher.grades.create') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <select name="course_id" class="form-select" onchange="this.form.submit()">
                @foreach ($courses as $c)
                    <option value="{{ $c->id }}" {{ $courseId === $c->id ? 'selected' : '' }}>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle">Student</th>
                            @foreach (\App\Models\Grade::WEIGHTS as $name => $max)
                                <th colspan="2" class="text-center">
                                    {{ $name }}<br>
                                    <small class="text-muted fw-normal">out of {{ $max }}</small>
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach (\App\Models\Grade::WEIGHTS as $name => $max)
                                <th class="text-center small text-muted">Score</th>
                                <th class="text-center small text-muted">Remark</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td class="fw-semibold">{{ $student->user->name }}</td>
                                @foreach (\App\Models\Grade::WEIGHTS as $name => $max)
                                    @php
                                        $existing = $existingGrades[$student->id][$name] ?? null;
                                        $key = $student->id . '_' . Str::slug($name, '_');
                                    @endphp
                                    <td style="min-width:90px;">
                                        <input
                                            type="number"
                                            step="0.01" min="0" max="{{ $max }}"
                                            name="grades[{{ $student->id }}][{{ $name }}][score]"
                                            value="{{ old("grades.{$student->id}.{$name}.score", $existing?->score) }}"
                                            placeholder="0–{{ $max }}"
                                            class="form-control form-control-sm"
                                        >
                                    </td>
                                    <td style="min-width:130px;">
                                        <input
                                            type="text"
                                            name="grades[{{ $student->id }}][{{ $name }}][remark]"
                                            value="{{ old("grades.{$student->id}.{$name}.remark", $existing?->remarks) }}"
                                            placeholder="Remark…"
                                            class="form-control form-control-sm"
                                        >
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 1 + count(\App\Models\Grade::WEIGHTS) * 2 }}" class="text-center py-4 text-muted">
                                    No students enrolled in this course.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->isNotEmpty())
                <button type="submit" class="btn btn-primary mt-2">Save Grades</button>
            @endif
        </form>
    @else
        <p class="text-muted">You have no assigned courses yet.</p>
    @endif

@endsection
