<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <--- BARIS INI WAJIB ADA

class CoffeeBean extends Model
{
    // Pastikan fillable sudah didefinisikan (contoh)
protected $fillable = ['name', 'origin', 'global_stock_kg', 'price_250g', 'description', 'image_url'];
    /**
     * Relasi Many-to-Many dengan Outlet (melalui pivot table bean_outlet_stock)
     */
    public function outlets(): BelongsToMany
    {
        return $this->belongsToMany(Outlet::class, 'bean_outlet_stock', 'coffee_bean_id', 'outlet_id')
                    ->withPivot('stock_kg');
    }
}