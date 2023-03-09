<?php

namespace App\Http\Controllers;

use App\Exceptions\DefaultException;
use App\Http\Requests\AccountLoginRequest;
use App\Models\Member;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * 登录
     *
     * @param AccountLoginRequest $request
     * @return array
     * @throws Exception
     */
    public function login(AccountLoginRequest $request)
    {
        $address = strtolower($request->input('address'));
        $lock = lock('auth_login_' . $address);
        if (!$lock->get()) {
            throw new DefaultException('请勿频繁操作');
        }

        try {
            $account = Member::where('address', $address)->first();
            if (empty($account)) {
                $account = Member::create(['address' => $address]);
            }
            /** @var JWTAuth|AuthManager $auth */
            $auth = auth();
            $token = $auth->fromUser($account);
            $auth->setToken($token);

            $lock->release();
            return $this->formatToken($token);
        } catch (Exception $e) {
            $lock->release();
            throw $e;
        }
    }

    /**
     * 刷新token
     *
     * @return array
     */
    public function refreshToken(): array
    {
        /** @var JWTAuth $auth */
        $auth = auth();

        return $this->formatToken($auth->refresh());
    }

    public function info(): array
    {
        $member = Auth::user();
        $data = $member->only(['id', 'checksum_address', 'address', 'nickname', 'avatar', 'default_avatar']);
        if ($member->is_city_node) {
            $data['city_node_level'] = (int)$member->city_node_level;
        } else {
            $data['city_node_level'] = 0;
        }
        return $data;
    }

    /**
     * 格式化token返回
     *
     * @param string $token
     * @return array
     */
    protected function formatToken(string $token): array
    {
        /** @var JWTAuth $auth */
        $auth = auth();

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expired_at' => time() - 60 + $auth->factory()->getTTL() * 60,
        ];
    }
}
