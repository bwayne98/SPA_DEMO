<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'chName',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model){
            $model -> id = Str::uuid();
        });

    }

    public function lessonDetails(){
        return $this->hasMany(LessonDetail::class);
    }

}
