<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'dob',
        'address',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A student can be enrolled in many courses.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendancePercentage(): float
    {
        $total = $this->attendances()->count();

        if ($total === 0) {
            return 0;
        }

        $present = $this->attendances()->where('status', 'present')->count();

        return round(($present / $total) * 100, 1);
    }
}
