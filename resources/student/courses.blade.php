@extends('layouts.app')

@section('title', 'My Course')

@section('content')

    <h3 class="mb-3">My Course</h3>

    @if ($student && $student->course)
        <div class="card">
            <div class="card-body">
                <h5>{{ $student->course->name }} ({{ $student->course->code }})</h5>
                <p class="mb-0">Instructor: {{ $student->course->teacher->user->name ?? 'Unassigned' }}</p>
            </div>
        </div>
    @else
        <p class="text-muted">You are not enrolled in a course yet. Please contact the administration.</p>
    @endif

@endsection
