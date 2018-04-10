<?php

namespace App\GraphQL\Queries;

use Nuwave\Lighthouse\Support\Schema\GraphQLResolver;
use Illuminate\Auth\Access\AuthorizationException;

class Viewer extends GraphQLResolver
{
    // use \App\GraphQL\ResolveLogTrait;

    public function resolve()
    {
        if(!$this->context || !$this->context->user){
            throw new AuthorizationException('Unauthorized');
            return null;
        }
        return $this->context->user; // User::find($context->id);
    }
}
