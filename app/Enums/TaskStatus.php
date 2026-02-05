<?php

namespace App\Enums;

enum TaskStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Новая',
            self::IN_PROGRESS => 'В работе',
            self::COMPLETED => 'Завершена',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
