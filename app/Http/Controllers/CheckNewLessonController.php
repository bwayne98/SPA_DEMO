<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckNewLessonController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)


    {
        /**
         * $requst=[
         * 'dates' => [24],
         * 'days' => string,
         * 'period' => 18 or 20
         * ]
         */

         
        $start = Carbon::parse($request->dates['1']);
        $end = Carbon::parse($request->dates['24']);

        $lessons = Lesson::select('teacher_id','room')->where(function($query) use ($start,$request){
            $query->where('start','<',$start)
            ->where('end','>',$start)
            ->where('period',$request->days.'-'.$request->period);
        })->orwhere(function($query) use ($end,$request){
            $query->where('start','<',$end)
            ->where('end','>',$end)
            ->where('period',$request->days.'-'.$request->period);
        })->get();

        $rooms = array("0","2A", "2S", "2B", "3A", "3S", "3B", "4A", "4S", "4B");

        $teachers = Teacher::select('id','enName')->where(function($query) use ($lessons,$rooms){
            foreach($lessons as $lesson){
                $query->where('id','!=',$lesson->teacher_id);
            }
        })->get();

        $rooms = array_filter($rooms,function($room){
            if ($room == '0') return false;
            return true;
        });

        foreach($lessons as $lesson){
            $rooms = array_filter($rooms,function($room) use ($lesson){
                if ($room == '0') return false;
                if ($room == $lesson->room){
                    return false;
                }else{
                    return true;
                }
            });
        }

        return [$lessons,$teachers,(array)$rooms];
    }
}
