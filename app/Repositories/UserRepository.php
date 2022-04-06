<?php

namespace App\Repositories;

use App\Models\Budget\User;

class UserRepository extends Controller implements Interfaces\UserInterface
{
    /**
     * @inheritDoc
     */
    public function list_users(): object
    {
        $users = User::all();
        return $this->callback(true, "Success retrieve data", $users);
    }
}
