<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserInterface $userRepository
     */
    protected UserInterface $userRepository;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->userRepository = $user;
    }

    /**
     * @return JsonResponse
     */
    public function list_all(): JsonResponse
    {
        $callbackRead = $this->userRepository->list_users();
        return $this->BuildResponse(200, $callbackRead->message, $callbackRead->data);
    }
}
