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

}
