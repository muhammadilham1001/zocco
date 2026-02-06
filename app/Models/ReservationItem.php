<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    protected $guarded = [];

    // Relasi balik ke Reservasi
    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }

    // Relasi ke Menu untuk mengambil Nama Menu, Gambar, dll
    public function menu() {
        return $this->belongsTo(Menu::class);
    }
}