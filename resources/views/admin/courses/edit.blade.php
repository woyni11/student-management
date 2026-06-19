@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')

    <h3 class="mb-3">Edit Course</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.courses.update', $course) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.courses._form', ['course' => $course])

                <button type="submit" class="btn btn-primary">Update Course</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
