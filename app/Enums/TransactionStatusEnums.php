<?php

namespace App\Enums;

enum TransactionStatusEnums : int {
    case RECEIVED_FAILED = 24;
    case SENT    = 25;
    case PENDING = 26;
    case CLAIMED = 27;
    case EXPIRED = 28;
    case REFUND  = 29;
}
