<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;


    public function viewAny()
    {
        return true;
    }


    public function view(User $user, Item $item)
    {
        return $user->company_id === $item->company_id;
    }


    public function create()
    {
        return true;
    }

    public function update(User $user, Item $item)
    {

        return $user->company_id === $item->company_id;
    }

    public function delete(User $user, Item $item)
    {
        return $user->company_id === $item->company_id;
    }

}
