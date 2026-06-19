@extends('layouts.app')

@section('title', 'Courses')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Courses</h3>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add Course</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Name</th><th>Code</th><th>Teacher</th><th>Students</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->teacher->user->name ?? '— unassigned —' }}</td>
                            <td>{{ $course->students_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No courses found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $courses->links() }}</div>

@endsection
