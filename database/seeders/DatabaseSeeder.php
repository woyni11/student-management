<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin ---
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@school.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // --- 6 Teachers, each assigned to 1 course ---
        $courseList = [
            ['name' => 'Introduction to Programming', 'code' => 'CS101'],
            ['name' => 'Data Structures',              'code' => 'CS102'],
            ['name' => 'Database Systems',             'code' => 'CS103'],
            ['name' => 'Web Development',               'code' => 'CS104'],
            ['name' => 'Computer Networks',             'code' => 'CS105'],
            ['name' => 'Software Engineering',          'code' => 'CS106'],
        ];

        $teacherList = [
            ['name' => 'Mr. Yonas Tadesse',  'email' => 'teacher@school.test', 'phone' => '0911223344', 'department' => 'Computer Science'],
            ['name' => 'Ms. Tigist Mulu',    'email' => 'tigist@school.test',  'phone' => '0911223345', 'department' => 'Computer Science'],
            ['name' => 'Ms. Helen Girma',    'email' => 'helen@school.test',   'phone' => '0911223346', 'department' => 'Information Systems'],
            ['name' => 'Mr. Biniam Tesfaye', 'email' => 'biniam@school.test',  'phone' => '0911223347', 'department' => 'Software Engineering'],
            ['name' => 'Ms. Lily Abebe',     'email' => 'lily@school.test',    'phone' => '0911223348', 'department' => 'Networking'],
            ['name' => 'Mr. Samuel Wolde',   'email' => 'samuel@school.test',  'phone' => '0911223349', 'department' => 'Software Engineering'],
        ];

        $courses = [];

        foreach ($courseList as $i => $c) {
            $teacherData = $teacherList[$i];

            $teacherUser = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);

            $teacher = $teacherUser->teacher()->create([
                'phone' => $teacherData['phone'],
                'department' => $teacherData['department'],
            ]);

            $courses[] = Course::create([
                'name' => $c['name'],
                'code' => $c['code'],
                'teacher_id' => $teacher->id,
            ]);
        }

        // --- 15 Students, each enrolled in 3 of the 6 courses ---
        $studentList = [
            ['name' => 'Abebe Kebede',    'email' => 'abebe@school.test',     'phone' => '0911000001', 'dob' => '2002-01-15', 'address' => 'Addis Ababa'],
            ['name' => 'Sara Tesfaye',    'email' => 'sara@school.test',      'phone' => '0911000002', 'dob' => '2003-03-22', 'address' => 'Addis Ababa'],
            ['name' => 'Dawit Alemu',     'email' => 'dawit@school.test',     'phone' => '0911000003', 'dob' => '2002-07-09', 'address' => 'Bahir Dar'],
            ['name' => 'Hana Girma',      'email' => 'hana@school.test',      'phone' => '0911000004', 'dob' => '2003-11-30', 'address' => 'Hawassa'],
            ['name' => 'Yared Solomon',   'email' => 'yared@school.test',     'phone' => '0911000005', 'dob' => '2002-05-18', 'address' => 'Adama'],
            ['name' => 'Mahlet Bekele',   'email' => 'mahlet@school.test',    'phone' => '0911000006', 'dob' => '2003-09-02', 'address' => 'Addis Ababa'],
            ['name' => 'Kebede Worku',    'email' => 'kebede@school.test',    'phone' => '0911000007', 'dob' => '2002-02-27', 'address' => 'Mekelle'],
            ['name' => 'Selam Asfaw',     'email' => 'selam@school.test',     'phone' => '0911000008', 'dob' => '2003-12-14', 'address' => 'Gondar'],
            ['name' => 'Tewodros Haile',  'email' => 'tewodros@school.test',  'phone' => '0911000009', 'dob' => '2002-08-21', 'address' => 'Dire Dawa'],
            ['name' => 'Rahel Mekonnen',  'email' => 'rahel@school.test',     'phone' => '0911000010', 'dob' => '2003-04-06', 'address' => 'Jimma'],
            ['name' => 'Eyob Tariku',     'email' => 'eyob@school.test',      'phone' => '0911000011', 'dob' => '2002-10-11', 'address' => 'Addis Ababa'],
            ['name' => 'Bethlehem Fikre', 'email' => 'bethlehem@school.test', 'phone' => '0911000012', 'dob' => '2003-06-25', 'address' => 'Bahir Dar'],
            ['name' => 'Nathnael Girma',  'email' => 'nathnael@school.test',  'phone' => '0911000013', 'dob' => '2002-12-03', 'address' => 'Hawassa'],
            ['name' => 'Hiwot Demissie',  'email' => 'hiwot@school.test',     'phone' => '0911000014', 'dob' => '2003-02-19', 'address' => 'Adama'],
            ['name' => 'Yonatan Assefa',  'email' => 'yonatan@school.test',   'phone' => '0911000015', 'dob' => '2002-09-08', 'address' => 'Mekelle'],
        ];

        $courseCount = count($courses);

        foreach ($studentList as $i => $s) {
            $studentUser = User::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            $student = $studentUser->student()->create([
                'phone' => $s['phone'],
                'dob' => $s['dob'],
                'address' => $s['address'],
                'status' => 'active',
            ]);

            // Rotate through the 6 courses so each student gets 3 different
            // ones, instead of everyone being enrolled in the same 3.
            $enrolledCourseIds = [
                $courses[$i % $courseCount]->id,
                $courses[($i + 1) % $courseCount]->id,
                $courses[($i + 2) % $courseCount]->id,
            ];

            $student->courses()->sync($enrolledCourseIds);
        }
    }
}
