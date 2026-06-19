@extends('layouts.app')

@section('title', 'Add Student')

@section('content')

    <h3 class="mb-3">Add New Student</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                @include('admin.students._form')

                <button type="submit" class="btn btn-primary">Save Student</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
