<?php

namespace App\GraphQL\Mutations;

use Nuwave\Lighthouse\Support\Schema\GraphQLResolver;
use Illuminate\Auth\Access\AuthorizationException;
use App\User;
use Carbon\Carbon;

class Login extends GraphQLResolver
{
    // use \App\GraphQL\ResolveLogTrait;

    public function resolve()
    {
        $user = User::where('email', $this->args['username'])->first();

        if ($user && app('hash')->check($this->args['password'], $user->password)) {
            $this->deleteExpiredTokens($user);
            $token = $user->createToken('APP_MOBILE')->accessToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }

        throw new AuthorizationException('Invalid credentials!');
        return null;
    }

    protected function deleteExpiredTokens($user)
    {
        $user->tokens()->where('expires_at', '<=', Carbon::now())->delete();
    }
}
