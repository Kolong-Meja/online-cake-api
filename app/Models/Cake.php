<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cake extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cakes';

    protected $fillable = [
        'name',
        'description',
        'weight',
        'price', 
        'stock',
        'status',
    ];

    // relation with cart model
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'cake_id');
    }
}
