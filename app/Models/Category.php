<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name','outlet_id'];

    /**
     * Relasi Balik: Kategori dimiliki oleh satu Outlet.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    /**
     * Relasi: Satu Kategori memiliki banyak Menu.
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}