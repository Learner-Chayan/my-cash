<?php 

namespace App\Enums;


enum TransactionTypeEnums: int {
    case DEPOSIT  = 300;
    case SEND = 301;
    case RECEIVED = 302;
    case REFUND = 303;
    case GIFT = 304;
    case TOPUP = 305;
    case WITHDRAW  = 306;

}