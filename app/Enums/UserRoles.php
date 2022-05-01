<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
}
