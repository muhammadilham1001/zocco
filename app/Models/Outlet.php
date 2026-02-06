<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Penting untuk generate random hash
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outlet extends Model
{
    use HasFactory;

    /**
     * Konfigurasi Primary Key agar menggunakan String, bukan Integer Auto-increment
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Kolom yang dapat diisi melalui mass assignment
     */
    protected $fillable = [
        'id', 
        'name', 
        'city', 
        'email',
        'image', 
        'logo',
        'wa',
        'ig',
        'tt',
    ];

    /**
     * Boot function untuk meng-generate Hash ID secara otomatis saat data dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Menghasilkan 10 karakter random (huruf & angka)
                $model->{$model->getKeyName()} = Str::random(10);
            }
        });
    }

    /**
     * Relasi ke Tabel Menu
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'outlet_id', 'id');
    }

    /**
     * Relasi ke Tabel Category
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'outlet_id', 'id');
    }

    /**
     * Relasi ke Tabel Reservation (Pemesanan Meja)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'outlet_id', 'id');
    }

    /**
     * Relasi Many-to-Many dengan CoffeeBean (Stok Biji Kopi)
     */
    public function coffeeBeans(): BelongsToMany
    {
        return $this->belongsToMany(CoffeeBean::class, 'bean_outlet_stock', 'outlet_id', 'coffee_bean_id')
                    ->withPivot('stock_kg')
                    ->withTimestamps();
    }

    /**
     * Relasi Many-to-Many dengan Merchandise (Stok Merchandise)
     */
    public function merchandises(): BelongsToMany
    {
        return $this->belongsToMany(Merchandise::class, 'merchandise_outlet_stock', 'outlet_id', 'merchandise_id')
                    ->withPivot('stock_unit')
                    ->withTimestamps();
    }
}