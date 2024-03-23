<?php 

namespace App\Enums;


enum TransactionTypeEnums: int {
    case DEPOSIT  = 30;
    case SEND = 31;
    case RECEIVED = 32;
    case REFUND = 33;
    case GIFT = 34;
    case TOPUP = 35;
    case WITHDRAW  = 36;

}