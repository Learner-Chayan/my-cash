<?php

namespace App\Enums;

enum TransactionStatusEnums : int {
    case PENDING = 10;
    case CLAIMED = 15;
    case EXPIRED = 20;
    case REFUND  = 21;
}
