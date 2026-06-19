@extends('layouts.app')

@section('title', 'Add Course')

@section('content')

    <h3 class="mb-3">Add New Course</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                @include('admin.courses._form')

                <button type="submit" class="btn btn-primary">Save Course</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
