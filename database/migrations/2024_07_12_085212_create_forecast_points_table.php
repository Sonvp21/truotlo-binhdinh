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
        Schema::create('forecast_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('forecast_sessions')->onDelete('cascade');
            $table->string('ten_diem', 6);
            $table->string('vi_tri');
            $table->decimal('kinh_do');
            $table->decimal('vi_do');
            $table->string('tinh');
            $table->string('huyen');
            $table->string('xa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecast_points');
    }
};
