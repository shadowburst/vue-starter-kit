<?php

namespace App\Providers;

use App\Actions\Auth\CreateNewUser;
use App\Actions\Auth\ResetUserPassword;
use App\Actions\Auth\UpdateUserPassword;
use App\Actions\Auth\UpdateUserProfileInformation;
use App\Data\Auth\ConfirmPassword\ConfirmPasswordProps;
use App\Data\Auth\ForgotPassword\ForgotPasswordProps;
use App\Data\Auth\Login\LoginProps;
use App\Data\Auth\Register\RegisterProps;
use App\Data\Auth\ResetPassword\ResetPasswordProps;
use App\Data\Auth\VerifyEmail\VerifyEmailProps;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

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
    public function boot(): void
    {
        Fortify::loginView(
            fn (Request $request) => inertia('auth/Login', LoginProps::from([
                'status'           => $request->session()->get('status'),
                'canResetPassword' => Features::enabled(Features::resetPasswords()),
            ])),
        );

        Fortify::registerView(
            fn (Request $request) => inertia('auth/Register', RegisterProps::from([
                'status' => $request->session()->get('status'),
            ])),
        );
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::requestPasswordResetLinkView(
            fn (Request $request) => inertia('auth/ForgotPassword', ForgotPasswordProps::from([
                'status' => $request->session()->get('status'),
            ])),
        );
        Fortify::resetPasswordView(
            fn (Request $request) => inertia('auth/ResetPassword', ResetPasswordProps::from([
                'status' => $request->session()->get('status'),
                'token'  => $request->route('token'),
                'email'  => $request->get('email'),
            ])),
        );
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::confirmPasswordView(
            fn (Request $request) => inertia('auth/ConfirmPassword', ConfirmPasswordProps::from([
                'status' => $request->session()->get('status'),
            ])),
        );

        Fortify::verifyEmailView(
            fn (Request $request) => inertia('auth/VerifyEmail', VerifyEmailProps::from([
                'status' => $request->session()->get('status'),
            ])),
        );

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
