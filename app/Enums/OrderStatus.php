<?php

namespace App\Enums;

enum OrderStatus: string {
    case PENDING = "pending";
    case INVOICED = "invoiced";
    case PAID = "paid";
    case DELIVERED = "delivered";
    case CLOSED = "closed"; 
}