<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends Controller implements AuthInterface
{

    /**
     * @inheritDoc
     */
    public function auth_login(array $credentials): object
    {
        if (! $token = Auth::attempt($credentials)) {
            return $this->callback(false, "Unauthorized username or password is wrong");
        }

        return $this->callback(true, "Success login", $this->respond_with_token($token));
    }

    /**
     * @inheritDoc
     */
    public function auth_logout(): object
    {
        auth()->logout();
        return $this->callback(true, 'Successfully logged out');
    }

    /**
     * @inheritDoc
     */
    public function auth_refresh(): object
    {
        return $this->callback(true, "Refresh token", $this->respond_with_token(auth()->refresh()));
    }

    /**
     * @inheritDoc
     */
    public function auth_me(): object
    {
        return $this->callback(true, "Success get data login", auth()->user());
    }

    /**
     * @param $token
     * @return object
     */
    protected function respond_with_token($token): object
    {
        return (object)[
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }
}
