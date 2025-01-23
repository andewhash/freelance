<?php

namespace App\Enum\Transaction;

class TransactionStatusEnum
{
    const IN_WORK = "IN_WORK";

    const COMPLETED = "COMPLETED";

    const CANCELED = "CANCELED";

    public static function getAll(): array
    {
        return [
            self::IN_WORK,
            self::COMPLETED,
            self::CANCELED
        ];
    }
}
