<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    /**
     * Properti yang dapat diisi secara massal (mass assignable).
     * Ini sesuai dengan kolom-kolom yang ada di migrasi 'menus'.
     *
     * Termasuk 'outlet_id', 'name', 'category', 'image_url', 'description', 'price'.
     * Harga jual (price) ada di sini karena kita menggunakan skema One-to-Many.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'outlet_id',
        'name',
        'type',
        'allow_custom_note',
        'allow_ice_sugar_level',
        'allow_egg_option',
        'allow_spicy_option',
        'category_id',
        'image_url',
        'description',
        'price',
        'is_available'
    ];

    /**
     * RELASI: Menu dimiliki oleh SATU Outlet (One-to-Many: Belongs To).
     * * Tabel 'menus' memiliki kolom 'outlet_id'.
     */
    public function outlet(): BelongsTo
    {
        // Secara default akan mencari foreign key 'outlet_id'
     return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

  public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
}