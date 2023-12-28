<?php

namespace App\Enums;

enum UserStatusActivity: string {
    case OFFLINE = "offline";
    case ONLINE = "online";
}