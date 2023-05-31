<?php

namespace Modules\Project\Providers;

use Modules\Project\Repository\v1\App\ProjectInviteRepository;
use Modules\Project\Repository\v1\App\ProjectInviteRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Project\Repository\v1\App\ProjectMembershipRepository;
use Modules\Project\Repository\v1\App\ProjectMembershipRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectPageRepository;
use Modules\Project\Repository\v1\App\ProjectPageRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepository;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;

class ProjectRepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProjectInviteRepositoryInterface::class, ProjectInviteRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectMembershipRepositoryInterface::class, ProjectMembershipRepository::class);
        $this->app->bind(ProjectPageRepositoryInterface::class, ProjectPageRepository::class);
    }
}
