<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //view project gate
       /* Gate::define('view_project', function (User $user, Project $project) {
            return $user->id === $project->user_id;
        });*/

        //buy a project as a company
        Gate::define('buy_project', function (User $user, Project $project) {
            return $user->company->category->projects->contains($project);
        });
        Gate::define('show_project', function (User $user, Project $project) {
            if(auth()->user()->role === 'company') return $user->company->projects->contains($project);
            if(auth()->user()->role === 'client') return $user->projects->contains($project);
        });
    }
}
