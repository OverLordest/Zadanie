<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_models', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
           // $table->timestamps();
        });
        Schema::create('connect_stud-sub', function (Blueprint $table) {
            $table->id();
            $table->string('stud_id');
            $table->string('sub_id');
            $table->string('grade')->nullable();
            // $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_models');
        Schema::dropIfExists('connect_stud-sub');
    }
}
