<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonDetail;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ShowStudenLessonsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $id)
    {
        //
        $lessonsDetail = LessonDetail::where('student_id',$id)->get();
        $lessons_id= [];
        foreach ($lessonsDetail as $lesson){
            $lesson->attend = json_decode($lesson->attend);
            array_push($lessons_id, $lesson->lesson_id);
        }
        
        $lessons = Lesson::find($lessons_id);
        $teachers=[];
        foreach ($lessons as $lesson){
            $lesson->date = json_decode($lesson->date);
        }
        $lessons = $lessons->sortBy('id');
        foreach ($lessons as $lesson){
            array_push($teachers,Teacher::find($lesson->teacher_id));
        }
        return [$lessons,$teachers,$lessonsDetail];

    }
}
