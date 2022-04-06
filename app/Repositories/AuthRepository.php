<?php

namespace App\Repositories;

use App\Models\Budget\RoleBpu;
use App\Models\Budget\User;
use App\Repositories\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends Controller implements AuthInterface
{

    /**
     * @inheritDoc
     */
    public function auth_login(array $credentials): object
    {
        $user = User::where("id_user", $credentials["username"])->first();
        if ($user == null) return $this->callback(false, "Unauthorized username is wrong or not found");
        $user->makeVisible("password");
        if ($user->password != md5($credentials["password"])) return $this->callback(false, "Unauthorized password is wrong");
        if (! $token = auth("api")->login($user)) {
            return $this->callback(false, "Unauthorized username or password is wrong");
        }

        $user->makeHidden("password");
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
            'role_bpu' => $this->role_bpu(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }

    /**
     * @return array
     */
    protected function role_bpu(): array
    {
        $roleBpuUser = [];
        $feature = ["createBpu","validateBpu","approverBpu","knowledgeBpu"];
        foreach ($feature as $key => $value) {
            $roles = RoleBpu::where($this->column_feature($value),\auth()->user()->id_user)->get();
            foreach ($roles as $key => $valRole) {
                $roleBpuUser[$valRole->folder_name][$valRole->bpu]['role'][] = $value;
                $roleBpuUser[$valRole->folder_name][$valRole->bpu]['condition'][$value] = [
                    "key" => $valRole->condition,
                    "value" => $valRole->value_condition
                ];
            }
        }

        return $roleBpuUser;
    }

    /**
     * @param $feature
     * @return string
     */
    protected function column_feature($feature): string
    {
        $data = [
            "createBpu" => "create_bpu",
            "validateBpu" => "validate_bpu",
            "approverBpu" => "approver_bpu",
            "knowledgeBpu" => "knowledge_bpu",
        ];

        return $data[$feature];
    }
}
