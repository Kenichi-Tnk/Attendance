<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceCorrectsTable extends Migration
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
            $table->date('date'); // 日付
            $table->time('clock_in')->nullable(); // 出勤時間
            $table->time('clock_out')->nullable(); // 退勤時間
            $table->time('rest_start')->nullable(); // 休憩開始時間
            $table->time('rest_end')->nullable(); // 休憩終了時間
            $table->text('note')->nullable(); // 備考
            $table->enum('status', ['pending', 'approved'])->default('pending'); // 申請のステータス
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
