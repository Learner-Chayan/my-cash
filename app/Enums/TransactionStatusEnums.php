<?php

namespace App\Enums;

enum TransactionStatusEnums : int {
    case SENT    = 5;
    case PENDING = 10;
    case CLAIMED = 15;
    case EXPIRED = 20;
    case REFUND  = 21;
}
