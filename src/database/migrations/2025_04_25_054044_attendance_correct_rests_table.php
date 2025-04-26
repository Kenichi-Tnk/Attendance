<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttendanceCorrectRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_correct_rests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_correct_id');
            $table->time('rest_start');
            $table->time('rest_end');
            $table->timestamps();

            $table->foreign('attendance_correct_id')
                ->references('id')
                ->on('attendance_corrects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_correct_rests');
    }
}
