<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShoppingSession extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'shopping_sessions';

    protected $fillable = [
        'user_id',
        'total',
    ];

    protected $hidden = ['id'];

    // relation with user model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relation with cake model
    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cart_cakes', 'session_id', 'cake_id')->withTimestamps();
    }
}
