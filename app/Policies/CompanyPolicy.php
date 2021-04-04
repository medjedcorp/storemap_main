<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Company $company)
    {
        return $user->company_id === $company->id;
        // return false;
    }

    public function update(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }

}
