<?php

namespace App\Interactions;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Ksoft\Klaravel\Larapp;

class UserUpdate
{
    /**
     * {@inheritdoc}
     */
    public function validator($id, array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($id, array $data)
    {
        // $data['slug'] = str_slug(array_get($data, 'name'));

        return Larapp::interact(
            UserRepository::class . '@update',
            [$id, $data]
        );
    }
}
