<?php

namespace App\Enums;

enum TaskStatusEnum : string {
    case CREATED = 'Created';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';
}
