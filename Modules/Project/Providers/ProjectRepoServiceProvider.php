<?php

namespace Modules\Project\Providers;

use Modules\Project\Repository\Contracts\ProjectRepository;
use Modules\Project\Repository\Contracts\ProjectPageRepository;
use Modules\Project\Repository\Contracts\ProjectInviteRepository;
use Modules\Project\Repository\Eloquent\ProjectRepositoryEloquent;
use Modules\Project\Repository\Contracts\ProjectMembershipRepository;
use Modules\Project\Repository\Eloquent\ProjectPageRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectInviteRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectMembershipRepositoryEloquent;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Project\Repository\Contracts\ProjectTimeCategoryRepository;
use Modules\Project\Repository\Eloquent\ProjectTimeCategoryRepositoryEloquent;

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
        $this->app->bind(ProjectInviteRepository::class, ProjectInviteRepositoryEloquent::class);
        $this->app->bind(ProjectRepository::class, ProjectRepositoryEloquent::class);
        $this->app->bind(ProjectMembershipRepository::class, ProjectMembershipRepositoryEloquent::class);
        $this->app->bind(ProjectPageRepository::class, ProjectPageRepositoryEloquent::class);
        $this->app->bind(ProjectTimeCategoryRepository::class, ProjectTimeCategoryRepositoryEloquent::class);
    }
}
