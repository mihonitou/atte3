<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        /**
         * Fortify の会員登録処理をカスタマイズ
         */
        Fortify::createUsersUsing(CreateNewUser::class);

        // 会員登録フォームのビューを登録
        Fortify::registerView(function () {
            return view('auth.register');
        });

        /**
         * Fortify のログイン処理をカスタマイズ
         */
        Fortify::authenticateUsing(function (Request $request) {
            // LoginRequest を使用してバリデーションを実行
            $loginRequest = new LoginRequest();
            $loginRequest->merge($request->all());
            $loginRequest->validate();

            // ユーザー認証
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        // ログインフォームのビューを登録
        Fortify::loginView(function () {
            return view('auth.login');
        });
    }
}
