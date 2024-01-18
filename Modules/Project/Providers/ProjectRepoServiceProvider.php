<?php

namespace Modules\Project\Providers;

use Modules\Project\Entities\ProjectIssueStatus;
use Modules\Project\Repository\Contracts\ProjectRepository;
use Modules\Project\Repository\Contracts\ProjectPageRepository;
use Modules\Project\Repository\Contracts\ProjectIssueRepository;
use Modules\Project\Repository\Contracts\ProjectInviteRepository;
use Modules\Project\Repository\Contracts\ProjectTrackerRepository;
use Modules\Project\Repository\Eloquent\ProjectRepositoryEloquent;
use Modules\Project\Repository\Contracts\ProjectPriorityRepository;
use Modules\Project\Repository\Contracts\ProjectMembershipRepository;
use Modules\Project\Repository\Contracts\ProjectIssueStatusRepository;
use Modules\Project\Repository\Eloquent\ProjectPageRepositoryEloquent;
use Modules\Project\Repository\Contracts\ProjectTimeCategoryRepository;
use Modules\Project\Repository\Eloquent\ProjectIssueRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectInviteRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectTrackerRepositoryEloquent;
use Modules\Project\Repository\Contracts\ProjectIssueAttachmentRepository;
use Modules\Project\Repository\Eloquent\ProjectPriorityRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectMembershipRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectIssueStatusRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectTimeCategoryRepositoryEloquent;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Project\Repository\Contracts\BoardListRepository;
use Modules\Project\Repository\Contracts\BoardRepository;
use Modules\Project\Repository\Contracts\ProjectTimeEntryRepository;
use Modules\Project\Repository\Eloquent\BoardListRepositoryEloquent;
use Modules\Project\Repository\Eloquent\BoardRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectIssueAttachmentRepositoryEloquent;
use Modules\Project\Repository\Eloquent\ProjectTimeEntryRepositoryEloquent;

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
        $this->app->bind(ProjectTrackerRepository::class, ProjectTrackerRepositoryEloquent::class);
        $this->app->bind(ProjectIssueStatusRepository::class, ProjectIssueStatusRepositoryEloquent::class);
        $this->app->bind(ProjectIssueRepository::class, ProjectIssueRepositoryEloquent::class);
        $this->app->bind(ProjectPriorityRepository::class, ProjectPriorityRepositoryEloquent::class);
        $this->app->bind(ProjectIssueAttachmentRepository::class, ProjectIssueAttachmentRepositoryEloquent::class);
        $this->app->bind(ProjectTimeEntryRepository::class, ProjectTimeEntryRepositoryEloquent::class);
        $this->app->bind(BoardRepository::class, BoardRepositoryEloquent::class);
        $this->app->bind(BoardListRepository::class, BoardListRepositoryEloquent::class);
    }
}
