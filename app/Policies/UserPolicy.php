<?php

namespace App\Policies;

use Auth;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
    * Determine whether the user can update the given profile
    */

    public function update(User $user, User $signedInUser)
    {
    	return $signedInUser->id == $user->id;
    }

}
