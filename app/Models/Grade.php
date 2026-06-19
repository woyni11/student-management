<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    /**
     * Fixed assessment categories and their maximum score.
     * Total = 30 + 10 + 5 + 5 + 50 = 100
     */
    public const WEIGHTS = [
        'Mid Exam'     => 30,
        'Project'      => 10,
        'Quiz'         => 5,
        'Presentation' => 5,
        'Final Exam'   => 50,
    ];

    /**
     * Return a letter grade based on total score (out of 100).
     *
     * A+  90–100
     * A   85–89
     * A-  80–84
     * B+  75–79
     * B   70–74
     * B-  65–69
     * C+  60–64
     * C   50–59
     * C-  45–49
     * D   40–44
     * F   < 40
     */
    public static function remark(float $total): string
    {
        return match (true) {
            $total >= 90 => 'A+',
            $total >= 85 => 'A',
            $total >= 80 => 'A-',
            $total >= 75 => 'B+',
            $total >= 70 => 'B',
            $total >= 65 => 'B-',
            $total >= 60 => 'C+',
            $total >= 50 => 'C',
            $total >= 45 => 'C-',
            $total >= 40 => 'D',
            default      => 'F',
        };
    }

    protected $fillable = [
        'student_id',
        'course_id',
        'assessment',
        'score',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function weight(): int
    {
        return self::WEIGHTS[$this->assessment] ?? 0;
    }

    public function weightedScore(): float
    {
        return (float) $this->score;
    }
}
