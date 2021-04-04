<?php

namespace App\Policies;

// use App\Models\Item;
use App\Models\User;
// use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function viewAny()
    {
        return true;
    }


    public function view(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }


    public function create()
    {
        return true;
    }

    public function update(User $user, Company $company)
    {

        return $user->company_id === $company->id;

    }

    // public function delete(Company $company, User $user)
    // {
    //     return $company->id === $user->company_id;
    //     // return $user->company_id === $company->id;
    // }
    // public function delete(User $user, Company $company)
    // {
    //     return $user->company_id === $company->id;
    //     // return $user->company_id === $company->id;
    // }
}
