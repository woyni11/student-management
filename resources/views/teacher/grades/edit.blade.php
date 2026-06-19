@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Edit Grade</h3>
        <a href="{{ route('teacher.grades.index', ['course_id' => $grade->course_id]) }}" class="btn btn-secondary">
            &larr; Back to Grades
        </a>
    </div>

    <div class="card col-md-6">
        <div class="card-body">

            {{-- Read-only context --}}
            <dl class="row mb-4">
                <dt class="col-sm-4">Student</dt>
                <dd class="col-sm-8">{{ $grade->student->user->name }}</dd>

                <dt class="col-sm-4">Course</dt>
                <dd class="col-sm-8">{{ $grade->course->name }} ({{ $grade->course->code }})</dd>

                <dt class="col-sm-4">Assessment</dt>
                <dd class="col-sm-8">{{ $grade->assessment }} <span class="text-muted">(out of {{ $grade->weight() }})</span></dd>
            </dl>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher.grades.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Score <span class="text-muted fw-normal">(0 – {{ $grade->weight() }})</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="{{ $grade->weight() }}"
                        name="score"
                        value="{{ old('score', $grade->score) }}"
                        class="form-control"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Remarks <span class="text-muted fw-normal">(optional)</span></label>
                    <input
                        type="text"
                        name="remarks"
                        value="{{ old('remarks', $grade->remarks) }}"
                        class="form-control"
                        placeholder="e.g. Good effort, Needs improvement…"
                    >
                </div>

                <button type="submit" class="btn btn-primary">Update Grade</button>
            </form>

        </div>
    </div>

@endsection
