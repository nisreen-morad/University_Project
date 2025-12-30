<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->integer('staff_id'); // ID الدكتور من فريق الستاف
        $table->integer('room_id');  // ID المعمل من فريق الغرف
        $table->dateTime('start_time'); // بداية وقت الحجز
        $table->dateTime('end_time');   // نهاية وقت الحجز
        $table->string('status')->default('pending'); // حالة الحجز
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
