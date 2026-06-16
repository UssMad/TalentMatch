<?php

namespace App\Providers;

use App\Models\JobOffer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('modify', function (object $user, JobOffer $jobOffer) {
            return $jobOffer->user_id === $user->getKey();
        });
    }
}
