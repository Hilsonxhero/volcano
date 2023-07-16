<?php

use Modules\Project\Repository\Contracts\ProjectInviteRepository;
use Modules\Project\Repository\Contracts\ProjectMembershipRepository;
use Modules\Project\Repository\Contracts\ProjectPageRepository;
use Modules\Project\Repository\Contracts\ProjectRepository;


if (!function_exists('projectRepo')) {
    /**
     * Get the Project repo.
     *
     * @return ProjectRepository
     */
    function projectRepo(): ProjectRepository
    {
        return resolve(ProjectRepository::class);
    }
}


if (!function_exists('projectMembershipRepo')) {
    /**
     * Get the ProjectMembership repo.
     *
     * @return ProjectMembershipRepository
     */
    function projectMembershipRepo(): ProjectMembershipRepository
    {
        return resolve(ProjectMembershipRepository::class);
    }
}


if (!function_exists('projectPageRepo')) {
    /**
     * Get the ProjectPage repo.
     *
     * @return ProjectPageRepository
     */
    function projectPageRepo(): ProjectPageRepository
    {
        return resolve(ProjectPageRepository::class);
    }
}

if (!function_exists('projectInviteRepo')) {
    /**
     * Get the ProjectInvite repo.
     *
     * @return ProjectInviteRepository
     */
    function projectInviteRepo(): ProjectInviteRepository
    {
        return resolve(ProjectInviteRepository::class);
    }
}
