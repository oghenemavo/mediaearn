<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case OPENED = 'opened';
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}