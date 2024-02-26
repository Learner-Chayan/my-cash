<?php 

namespace App\Enums;


enum TransactionTypeEnums: int {
    case DEPOSIT  = 1;
    case SEND = 2;
    case RECEIVED = 3;
    case REFUND = 4;
    case GIFT = 5;
    case TOPUP = 6;
    case WITHDRAW  = 7;

}