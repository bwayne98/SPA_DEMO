<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonDetail;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LessonDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();

        $attend = json_encode([false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false]);

        foreach ($students as $student) {

            $num = rand(1, 5);
            $lessons = Lesson::all()->random($num);

            foreach ($lessons as $lesson) {
                LessonDetail::factory()->state([
                    'lesson_id' => $lesson->id,
                    'student_id' => $student->id,
                    'attend' => $attend,
                    'price' => Arr::random([3600,3400,3300,3000])
                ])->create();
            }
        }
    }
}
