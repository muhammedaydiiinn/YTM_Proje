<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PlayerProfileRepoInt;
use App\Repositories\PlayerProfileRepo;

class AppServiceProvider extends ServiceProvider
{
    // singleton sınıfının yalnızca bir kez oluşturulmasını sağlıyor.
    public function register()
    {
        $this->app->bind(PlayerProfileRepoInt::class, PlayerProfileRepo::class);
    }

    public function boot()
    {
        //
    }
}
