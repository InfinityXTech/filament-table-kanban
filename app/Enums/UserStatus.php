<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserStatus: string
{
    use IsKanbanStatus;

    case User = 'User';
    case Admin = 'Admin';
}