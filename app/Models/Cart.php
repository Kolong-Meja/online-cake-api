<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $table = "carts";

    protected $fillable = [
        "user_id",
        "cake_id",
        "quantity"
    ];

    // relation with user model
    public function user(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'user_id');
    }

    // relation with cake model
    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cake_id');
    }
}
