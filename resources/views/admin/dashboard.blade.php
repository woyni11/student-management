@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    <h3 class="mb-4">Admin Dashboard</h3>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2>{{ $stats['students'] }}</h2>
                    <p class="text-muted mb-0">Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2>{{ $stats['teachers'] }}</h2>
                    <p class="text-muted mb-0">Teachers</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2>{{ $stats['courses'] }}</h2>
                    <p class="text-muted mb-0">Courses</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary me-2">+ Add Student</a>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-success me-2">+ Add Teacher</a>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-secondary">+ Add Course</a>
    </div>

@endsection
