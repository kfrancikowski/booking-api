<?php

namespace App\Observers;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->uuid = Str::uuid();

        if(empty($user->role)) {
            $user->role = UserRoles::CLIENT;
        }
    }

}
