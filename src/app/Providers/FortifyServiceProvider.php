<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            // バリデーションを直接実行
            $credentials = $request->only('email', 'password');

            Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string',
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => '有効なメールアドレスを入力してください',
                'password.required' => 'パスワードを入力してください',
            ])->validate();

            // ユーザー認証
            $user = User::where('email', $credentials['email'])->first();
            if ($user && Hash::check($credentials['password'], $user->password)) {
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
