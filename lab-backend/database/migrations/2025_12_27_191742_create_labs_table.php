<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->string('name');    // اسم المختبر (مثلاً: Computer Lab 1)
            $table->string('floor');   // الطابق
            $table->string('status')->default('Available'); // الحالة: متاح، مشغول، أو صيانة
            $table->timestamps();      // يسجل وقت الإنشاء والتحديث تلقائياً
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
