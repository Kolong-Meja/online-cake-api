<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected $hidden = ['id'];

    // relation with order model
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'cake_orders', 'cake_id', 'order_id')->withTimestamps();
    }

    // relation with shopping session model
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(ShoppingSession::class, 'cart_cakes', 'cake_id', 'session_id')->withTimestamps();
    }
}
