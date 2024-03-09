<?php

namespace App\Enums;

enum TaskStatusEnum : string {
    case CREATED = 'Created';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';

    public static function randomValue(): string
    {
        $arr = array_column(self::cases(), 'value');
        return $arr[array_rand($arr)];
    }
}
