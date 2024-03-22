<?php

namespace App\Enums;

enum TransactionStatusEnums : int {
    case SENT    = 210;
    case PENDING = 211;
    case CLAIMED = 212;
    case EXPIRED = 213;
    case REFUND  = 214;
}
