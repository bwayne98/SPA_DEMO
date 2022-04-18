<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'array',
      ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function lessonDetails(){
        return $this->hasMany(LessonDetail::class);
    }

    public static function studentCount($lesson_id){
        // return LessonDetail::where('lesson_id', $lesson_id)->count() + Order::where('lesson_id', $lesson_id)->count();
        return Order::where('lesson_id', $lesson_id)->count();
    }

}
