<?php

namespace App\Policies;

use App\Models\ItemImage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemImagePolicy
{
    use HandlesAuthorization;

     public function delete(User $user, Itemimage $itemimage)
     {
         return $user->company_id === $itemimage->company_id;
     }
}
