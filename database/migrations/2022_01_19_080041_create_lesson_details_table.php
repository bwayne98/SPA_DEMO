<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_details', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('lesson_id')->constrained('lessons');
            $table->foreignUuid('student_id')->constrained('students');

            $table->json("attend")->nullable();

            $table->integer('price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_details');
    }
}
