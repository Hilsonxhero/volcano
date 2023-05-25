<?php

namespace Modules\Project\Http\Controllers\v1\App;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Services\ApiService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Project\Emails\InviteUserNotify;
use Modules\Project\Repository\v1\App\ProjectInviteRepositoryInterface;
use Modules\Project\Repository\v1\App\ProjectRepositoryInterface;
use Modules\User\Repository\v1\App\UserRepositoryInterface;

class ProjectController extends Controller
{
    public $projectInviteRepo;
    public $projectRepo;
    public $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        ProjectRepositoryInterface $projectRepo,
        ProjectInviteRepositoryInterface $projectInviteRepo
    ) {
        $this->projectInviteRepo = $projectInviteRepo;
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
    }
}
