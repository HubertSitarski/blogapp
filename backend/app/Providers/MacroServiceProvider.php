<?php

namespace App\Providers;

use Str;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('fixEncoding', function (string $string) {
            return mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        });
    }
}
