<?php

namespace App\Repositories\Interfaces;

Interface UserInterface
{
    /**
     * @return object
     */
    public function list_users(): object;
}
