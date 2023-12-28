<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_date',
        'status',
        'total_price',
        'shipping_address'
    ];

    protected $hidden = ['id'];

    protected $casts = [
        'order_date' => 'datetime',
        'status' => OrderStatus::class,
    ];

    // relation with user model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relation with cake model
    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cake_orders', 'order_id', 'cake_id')->withTimestamps();
    }
}
