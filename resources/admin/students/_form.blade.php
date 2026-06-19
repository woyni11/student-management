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
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $student->user->name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Password {{ isset($student) ? '(leave blank to keep current)' : '' }}</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Course</label>
        <select name="course_id" class="form-select">
            <option value="">— Not enrolled —</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id', $student->course_id ?? '') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }} ({{ $course->code }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control"
               value="{{ old('dob', isset($student) ? $student->dob?->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach (['active', 'inactive'] as $status)
                <option value="{{ $status }}" {{ old('status', $student->status ?? 'active') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $student->address ?? '') }}</textarea>
    </div>
</div>
