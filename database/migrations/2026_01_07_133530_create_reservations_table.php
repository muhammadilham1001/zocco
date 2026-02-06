<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel reservasi tanpa sistem QR.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (UUID)
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            // Relasi ke Outlet
            $table->string('outlet_id', 255); 
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');

            $table->string('customer_name');
            $table->string('phone_number');
            
            // TANGGAL DAN JAM (Pemisahan sesuai input form)
            $table->date('reservation_date'); 
            $table->time('reservation_time'); 
            
            $table->integer('guests');
            $table->text('note')->nullable();
            
            // STATUS RESERVASI
            $table->string('status')->default('pending'); // pending, confirmed, rejected, cancelled
            $table->text('rejection_reason')->nullable();

            // SISTEM PEMBAYARAN DP (Manual Transfer)
            $table->string('payment_proof')->nullable(); // Path foto bukti transfer
            $table->string('payment_status')->default('unpaid'); // unpaid, pending, paid
            
            // DETAIL LAYANAN
            $table->string('reservation_type')->default('reguler'); // reguler, vip
            $table->string('area')->nullable();
            $table->text('order_details')->nullable();
            $table->integer('duration')->nullable(); // Durasi jam (khusus VIP)
            $table->integer('dp')->nullable(); // Dp
            $table->boolean('addon_decoration')->default(false); // Tambahan dekorasi
            
            $table->timestamps();
        });
    }

    /**
     * Balikkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};