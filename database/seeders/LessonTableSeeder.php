<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Teacher;
use \App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use PDO;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
 
    public function run()
    {
        $times = ["18", "20"];
        $teachers = Teacher::all();
        
        foreach ($teachers as $teacher) {

            for ($t = 0; $t < rand(2, 4); $t++) {
                $start = Carbon::today();
                $start->subDay(rand(-180, 180));

                $period = $start->copy()->dayOfWeek;

                if ($period == 0) {
                    $start->subDay(rand(1, 3));
                }
                
                if ($period == 1 || $period == 4) {
                    $period_and_time = 'Mon-Thur-' . Arr::random($times);
                } elseif ($period == 2 || $period == 5) {                   
                    $period_and_time = 'Tue-Fri-' . Arr::random($times);
                } else {               
                    $period_and_time = 'Wed-Sat-' . Arr::random($times);
                }

                $dates = LessonTableSeeder::datePush($period, $start);
                $temp_rooms = LessonTableSeeder::checkRoom($period_and_time,$dates[0],$dates[23]);

                if ($temp_rooms != []){
                    Lesson::factory()->state([
                        'start' => $dates[0],
                        'end' => $dates[23],
                        'room' => Arr::random($temp_rooms),
                        'period' => $period_and_time,
                        'date' => json_encode($dates),
                        'teacher_id' => $teacher->id
                    ])->create();
                }else{
                    continue;
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

    public static function checkRoom(string $period_and_time,string $start,string $end) : array{
        $lessons = Lesson::where('period',$period_and_time)->get();
        $temp_rooms= ["2A","2S","2B", "3A", "3S", "3B", "4A", "4S", "4B"];
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        foreach ($lessons as $lesson){
            
            $dates = json_decode($lesson->date);
            $lesson_start = Carbon::parse($dates[0]);
            $lesson_end = Carbon::parse($dates[23]);

            if ($lesson_start < $end || $lesson_end > $start){
                $lesson_room = $lesson->room;

                $temp_rooms = array_filter($temp_rooms,function($item) use ($lesson_room){
                    return $item != $lesson_room;
                });

            }

        }

        return $temp_rooms;

    }

}
