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
    Schema::create('outlets', function (Blueprint $table) {
        $table->string('id', 255)->primary();
        $table->string('name')->unique(); 
        $table->string('city')->nullable();
        $table->string('email')->nullable();
        $table->string('image')->nullable();
        $table->string('logo')->nullable();
        $table->string('wa')->nullable();
        $table->string('ig')->nullable();
        $table->string('tt')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};