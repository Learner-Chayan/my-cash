<?php

namespace App\Enums;

interface TransactionStatusEnums {
    const RECEIVED_FAILED = 24;
    const SENT    = 25;
    const PENDING = 26;
    const CLAIMED = 27;
    const EXPIRED = 28;
    const REFUNDED  = 29;
}
