<?php

namespace App\Enum\Order;

class OrderStatusEnum
{
    const NEW = 'NEW';

    const WAITING_PAYMENT = 'WAITING_PAYMENT';

    const IN_WORK = 'IN_WORK';

    const VERIFICATION = 'VERIFICATION';

    const COMPLETED = 'COMPLETED';

    const CANCELLED = 'CANCELLED';

    public static function getAll(): array
    {
        return [
            self::NEW,
            self::WAITING_PAYMENT,
            self::IN_WORK,
            self::VERIFICATION,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }
}
