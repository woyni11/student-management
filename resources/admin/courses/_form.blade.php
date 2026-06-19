@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Course Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $course->name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Course Code</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $course->code ?? '') }}" placeholder="e.g. CS101">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Assigned Teacher</label>
        <select name="teacher_id" class="form-select">
            <option value="">— Unassigned —</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->user->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
