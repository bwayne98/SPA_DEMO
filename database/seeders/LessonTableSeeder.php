<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Teacher;
use \App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */




    public function run()
    {


        $teachers = Teacher::all();
        $times = ["18", "20"];
        foreach ($teachers as $teacher) {

            for ($t = 0; $t < rand(1, 5); $t++) {
                $start = Carbon::today();
                $start->subDay(rand(30, 180));

                $period = $start->copy()->dayOfWeek;

                if ($period == 0) {
                    $start->subDay(rand(1, 3));
                }
                $dates = [$start];
                if ($period == 1 || $period == 4) {
                    $dates = LessonTableSeeder::datePush($period, $start);
                    Lesson::factory()->state([
                        'start' => $start,
                        'end' => $dates[23],
                        'period' => 'Mon-Thur-' . Arr::random($times),
                        'date' => json_encode($dates),
                        'teacher_id' => $teacher->id
                    ])->create();
                } elseif ($period == 2 || $period == 5) {
                    $dates = LessonTableSeeder::datePush($period, $start);
                    
                    Lesson::factory()->state([
                        'start' => $start,
                        'end' => $dates[23],
                        'period' => 'Tue-Fri-' . Arr::random($times),
                        'date' => json_encode($dates),
                        'teacher_id' => $teacher->id
                    ])->create();
                } else {
                    $dates = LessonTableSeeder::datePush($period, $start);
                    
                    Lesson::factory()->state([
                        'start' => $start,
                        'end' => $dates[23],
                        'period' => 'Wed-Sat-' . Arr::random($times),
                        'date' => json_encode($dates),
                        'teacher_id' => $teacher->id
                    ])->create();
                }
            }
        }
    }

    public static function datePush(int $week, Carbon $start): array
    {
        $cur = $start->copy();
        $dates = [];
        array_push($dates, $start->copy()->format("Y-m-d"));
        while (count($dates) < 24) {
            if ($week == 1 || $week == 2 || $week == 3) {
                $cur->addDay(3);
                array_push($dates, $cur->copy()->format("Y-m-d"));
                $week = 4;
            } else {
                $cur->addDay(4);
                array_push($dates, $cur->copy()->format("Y-m-d"));
                $week = 1;
            }
        }
        return $dates;
    }
}
