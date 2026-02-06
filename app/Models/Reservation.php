<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 
    'outlet_id', 
    'customer_name', 
    'phone_number',
    'reservation_date',
    'reservation_time',
    'guests', 
    'note', 
    'status', 
    'rejection_reason', 
    'payment_proof', 
    'payment_status',
    'reservation_type', // Gunakan ini, jangan 'type'
    'area',             // Tambahkan ini (ada di migrasi)
    'order_details',    // Tambahkan ini (ada di migrasi)
    'duration',
    'dp',
    'addon_decoration'
    ];

    /**
     * Casting tipe data agar Laravel otomatis mengenali formatnya
     */
    protected $casts = [
        'reservation_date' => 'date',
        'addon_decoration' => 'boolean',
        'guests' => 'integer',
        'duration' => 'integer',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Outlet
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function items() {
        return $this->hasMany(ReservationItem::class);
    }
}