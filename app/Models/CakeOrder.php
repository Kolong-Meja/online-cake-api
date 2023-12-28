<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CakeOrder extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cake_orders';

    protected $fillable = [
        'cake_id',
        'order_id',
    ];

    protected $hidden = ['id'];
}
