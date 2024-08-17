<?php

namespace App\Providers;

use App\Services\Submissions\CreateSubmission;
use Illuminate\Support\ServiceProvider;

class SubmissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CreateSubmission::class, function () {
            return new CreateSubmission();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
