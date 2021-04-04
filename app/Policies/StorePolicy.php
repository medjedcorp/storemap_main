<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;
// use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;


    public function viewAny()
    {
        return true;
    }


    public function view(User $user, Store $store)
    {
        return $user->company_id === $store->company_id;
    }


    public function create()
    {
        return true;
    }

    public function update(User $user, Store $store)
    {

        return $user->company_id === $store->company_id;

    }

    public function delete(User $user, Store $store)
    {
        return $user->company_id === $store->company_id;
    }

}
