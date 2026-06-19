@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')

    <h3 class="mb-3">Edit Teacher</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.teachers._form', ['teacher' => $teacher])

                <button type="submit" class="btn btn-primary">Update Teacher</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
