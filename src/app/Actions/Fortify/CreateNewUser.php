<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a new user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // RegisterRequest のバリデーションルールを取得
        $rules = (new RegisterRequest)->rules();
        $messages = (new RegisterRequest)->messages();

        // Validator を直接使用してバリデーションを実行
        $validated = Validator::make($input, $rules, $messages)->validate();

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}


