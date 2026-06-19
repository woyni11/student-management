@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')

    <h3 class="mb-3">Edit Student</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.students._form', ['student' => $student])

                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
