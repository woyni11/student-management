@extends('layouts.app')

@section('title', 'Add Teacher')

@section('content')

    <h3 class="mb-3">Add New Teacher</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf
                @include('admin.teachers._form')

                <button type="submit" class="btn btn-primary">Save Teacher</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
