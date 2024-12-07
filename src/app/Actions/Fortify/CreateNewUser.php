<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateNewUser
{
    /**
     * 新規登録されたユーザーを作成します。
     */
    public function create(array $input): User
    {
        // RegisterRequest をインスタンス化し、バリデーションを実行
        $request = app(RegisterRequest::class);
        $request->merge($input); // $input データを RegisterRequest にセット
        $validated = $request->validated(); // バリデーション済みデータを取得

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}

