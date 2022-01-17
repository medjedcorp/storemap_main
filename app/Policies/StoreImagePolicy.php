<?php

namespace App\Policies;

use App\Models\StoreImage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreImagePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->role === "admin") {
            return true;
        }
    }

    public function delete(User $user, Storeimage $storeimage)
    {
        return $user->company_id === $storeimage->company_id;
    }
}
