<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Merchandise extends Model
{
    protected $fillable = [
        'name', 
        'category', 
        'global_stock_unit', 
        'price', 
        'description', 
        'image_url' 
    ];

    public function outlets(): BelongsToMany
    {
        return $this->belongsToMany(Outlet::class, 'merchandise_outlet_stock', 'merchandise_id', 'outlet_id')
                    ->withPivot('stock_unit');
    }
}