<?php

namespace App\Utils;

use Illuminate\Support\Facades\Auth;

class CheckRole {
    public static function authUserRole(): string
    {
        $authUserRole = Auth::user()->role->title;

        return $authUserRole;
    }
}