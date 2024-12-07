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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_work');
            $table->time('end_work')->nullable();
            $table->timestamps();

            // ユニークキーの追加
            $table->unique(['user_id', 'date']);

        });
    }

    /**
     * Reverse the migrations.
     *;;
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
