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
        <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Password {{ isset($teacher) ? '(leave blank to keep current)' : '' }}</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control" value="{{ old('department', $teacher->department ?? '') }}">
    </div>
</div>
