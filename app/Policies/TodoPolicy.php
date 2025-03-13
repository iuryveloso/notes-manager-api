<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodoPolicy
{
    /**
     * Determine whether the user can modify the model.
     */
    public function modify(User $user, Todo $todo): Response
    {
        return $user->id === $todo->user_id
            ? Response::allow()
            : Response::deny('You do not own this To do');
    }
}
