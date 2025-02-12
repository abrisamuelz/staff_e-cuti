<?php

namespace App\Providers;

use App\Models\Staff;
use App\Policies\StaffPolicy;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Staff::class => StaffPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

    }
}
