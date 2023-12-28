<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartCakes extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'cart_cakes';

    protected $fillable = [
        'session_id',
        'cake_id'
    ];

    protected $hidden = ['id'];
}
