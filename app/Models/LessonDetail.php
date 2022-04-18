<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'attend' => 'array',
      ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }


    public function studentCount($lesson_id){
        return LessonDetail::where('lesson_id', $lesson_id)->count() + Order::where('lesson_id',  $lesson_id)->where('paid', true)->where('check_in', false)->count();
    }

}
