<?php

namespace App\Interactions;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Ksoft\Klaravel\Larapp;

class UserCreate
{
    /**
     * {@inheritdoc}
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $data)
    {
        // $data['slug'] = str_slug(array_get($data, 'name'));


        $user = Larapp::interact(
            UserRepository::class . '@create',
            [$data]
        );

        return [
            'success' => true,
            'msg' => 'User created succesfully',
            'payload' => ''
        ];
    }
}
