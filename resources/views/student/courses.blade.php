@extends('layouts.app')

@section('title', 'My Courses')

@section('content')

    <h3 class="mb-3">My Courses</h3>

    @if ($student && $student->courses->isNotEmpty())
        <div class="row g-3">
            @foreach ($student->courses as $course)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>{{ $course->name }}</h5>
                            <p class="text-muted mb-0">Code: {{ $course->code }}</p>
                            <p class="mb-0">Instructor: {{ $course->teacher->user->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">You are not enrolled in any course yet. Please contact the administration.</p>
    @endif

@endsection
