<?php

namespace App\Enums;


interface TransactionTypeEnums{
    const DEPOSIT  = 30;
    const SEND = 31;
    const RECEIVED = 32;
    const REFUND = 33;
    const GIFT = 34;
    const TOPUP = 35;
    const WITHDRAW  = 36;

}
