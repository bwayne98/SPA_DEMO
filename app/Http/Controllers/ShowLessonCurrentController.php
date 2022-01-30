<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonDetail;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowLessonCurrentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $today = Carbon:: today();
        $lessons = Lesson::where('end','>',$today)->orderBy('end')->get();
        $teachers =[];
        $studentsCount = [];
        foreach ($lessons as $lesson){
            array_push($teachers,(Teacher::find($lesson->teacher_id)));
            array_push($studentsCount,(LessonDetail::where('lesson_id',$lesson->id)->count()));
        }

        return [ $lessons, $teachers,$studentsCount];
    }
}
