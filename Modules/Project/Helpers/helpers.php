<?php

use Modules\Project\Repository\Contracts\BoardListRepository;
use Modules\Project\Repository\Contracts\BoardRepository;
use Modules\Project\Repository\Contracts\ProjectInviteRepository;
use Modules\Project\Repository\Contracts\ProjectIssueAttachmentRepository;
use Modules\Project\Repository\Contracts\ProjectIssueRepository;
use Modules\Project\Repository\Contracts\ProjectIssueStatusRepository;
use Modules\Project\Repository\Contracts\ProjectMembershipRepository;
use Modules\Project\Repository\Contracts\ProjectPageRepository;
use Modules\Project\Repository\Contracts\ProjectPriorityRepository;
use Modules\Project\Repository\Contracts\ProjectRepository;
use Modules\Project\Repository\Contracts\ProjectTimeCategoryRepository;
use Modules\Project\Repository\Contracts\ProjectTimeEntryRepository;
use Modules\Project\Repository\Contracts\ProjectTrackerRepository;

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

if (!function_exists('projectTimeCategoryRepo')) {
    /**
     * Get the ProjectTimeCategory repo.
     *
     * @return ProjectTimeCategoryRepository
     */
    function projectTimeCategoryRepo(): ProjectTimeCategoryRepository
    {
        return resolve(ProjectTimeCategoryRepository::class);
    }
}
if (!function_exists('projectTrackerRepo')) {
    /**
     * Get the ProjectTracker repo.
     *
     * @return ProjectTrackerRepository
     */
    function projectTrackerRepo(): ProjectTrackerRepository
    {
        return resolve(ProjectTrackerRepository::class);
    }
}

if (!function_exists('projectIssueStatusRepo')) {
    /**
     * Get the projectIssueStatus repo.
     *
     * @return ProjectIssueStatusRepository
     */
    function projectIssueStatusRepo(): ProjectIssueStatusRepository
    {
        return resolve(ProjectIssueStatusRepository::class);
    }
}

if (!function_exists('projectIssueRepo')) {
    /**
     * Get the projectIssue repo.
     *
     * @return ProjectIssueRepository
     */
    function projectIssueRepo(): ProjectIssueRepository
    {
        return resolve(ProjectIssueRepository::class);
    }
}

if (!function_exists('projectPriorityRepo')) {
    /**
     * Get the ProjectPriority repo.
     *
     * @return ProjectPriorityRepository
     */
    function projectPriorityRepo(): ProjectPriorityRepository
    {
        return resolve(ProjectPriorityRepository::class);
    }
}

if (!function_exists('projectIssueAttachmentRepo')) {
    /**
     * Get the projectIssueAttachment repo.
     *
     * @return ProjectIssueAttachmentRepository
     */
    function projectIssueAttachmentRepo(): ProjectIssueAttachmentRepository
    {
        return resolve(ProjectIssueAttachmentRepository::class);
    }
}


if (!function_exists('ProjectTimeEntryRepo')) {
    /**
     * Get the ProjectTimeEntry repo.
     *
     * @return ProjectTimeEntryRepository
     */
    function ProjectTimeEntryRepo(): ProjectTimeEntryRepository
    {
        return resolve(ProjectTimeEntryRepository::class);
    }
}


if (!function_exists('boardRepo')) {
    /**
     * Get the board repo.
     *
     * @return BoardRepository
     */
    function boardRepo(): BoardRepository
    {
        return resolve(BoardRepository::class);
    }
}


if (!function_exists('boardListRepo')) {
    /**
     * Get the boardList repo.
     *
     * @return BoardListRepository
     */
    function boardListRepo(): BoardListRepository
    {
        return resolve(BoardListRepository::class);
    }
}
