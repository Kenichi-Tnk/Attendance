<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date'); //日付
            $table->timestamp('clock_in')->nullable(); //出勤時間
            $table->timestamp('clock_out')->nullable(); //退勤時間
            $table->enum('status', ['not_started', 'working', 'on_break', 'finished'])->default('not_started'); // 出勤状態
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
        Schema::dropIfExists('attendances');

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
