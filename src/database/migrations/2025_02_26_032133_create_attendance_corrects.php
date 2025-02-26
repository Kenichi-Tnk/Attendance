<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceCorrects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_corrects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('attendance_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['clock_in', 'clock_out', 'rest_start', 'rest_end']); // 修正の種類
            $table->timestamp('requested_time'); // 申請された時間
            $table->text('reason'); // 修正理由
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // 申請のステータス
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
        Schema::dropIfExists('attendance_corrects');
    }
}
