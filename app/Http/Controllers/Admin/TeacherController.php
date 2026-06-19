<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $teachers = Teacher::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.teachers.index', compact('teachers', 'search'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateTeacher($request);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
            ]);

            $user->teacher()->create([
                'phone' => $validated['phone'],
                'department' => $validated['department'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $this->validateTeacher($request, $teacher->user_id);

        DB::transaction(function () use ($validated, $teacher) {
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (! empty($validated['password'])) {
                $teacher->user->update(['password' => Hash::make($validated['password'])]);
            }

            $teacher->update([
                'phone' => $validated['phone'],
                'department' => $validated['department'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    private function validateTeacher(Request $request, $ignoreUserId = null): array
    {
        $passwordRule = $ignoreUserId ? ['nullable', 'string', 'min:6'] : ['required', 'string', 'min:6'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignoreUserId)],
            'password' => $passwordRule,
            'phone' => ['required', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
