<?php

namespace App\Providers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        // Override bcrypt untuk menerima $2b$ hash
        Hash::extend('bcrypt', function () {
            return new BcryptHasher([
                'rounds' => env('BCRYPT_ROUNDS', 10),
            ]);
        });
    }
}
