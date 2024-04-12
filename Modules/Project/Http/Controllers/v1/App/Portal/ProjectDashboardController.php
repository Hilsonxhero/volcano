<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\ProjectIssue;
use Modules\Project\Entities\ProjectTimeEntry;

class ProjectDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $user = auth()->user();
        $project = projectRepo()->find($id);

        $currentDate = Carbon::now();

        if ($user->id == $project->user_id) {
            $today_issues = ProjectIssue::query()
                ->whereDate('created_at', Carbon::today())
                ->count();

            $delayed_issues = ProjectIssue::query()
                ->whereDate('end_date', '<', $currentDate)
                ->count();

            $trackable_issues = ProjectIssue::query()
                ->whereDate('end_date', '>', $currentDate)
                ->count();
            $times = ProjectTimeEntry::query()->where('project_id', $project->id)->get();
        } else {
            $today_issues = ProjectIssue::query()
                ->whereDate('created_at', Carbon::today())
                ->where('assigned_to_id', $user->id)
                ->count();

            $delayed_issues = ProjectIssue::query()
                ->whereDate('end_date', '<', $currentDate)
                ->where('assigned_to_id', $user->id)
                ->count();

            $trackable_issues = ProjectIssue::query()
                ->whereDate('end_date', '>', $currentDate)
                ->where('assigned_to_id', $user->id)
                ->count();
            $times = ProjectTimeEntry::query()
                ->where('user_id', $user->id)
                ->where('project_id', $project->id)->get();
        }
        $users_count = $project->members()->count();
        $boards_count = $project->boards()->count();

        $totalHours = $times->reduce(function ($total, $time) {
            return $total + $time->total_hours;
        }, 0);

        $totalHours = sprintf("%02d:%02d", $totalHours / 60, $totalHours % 60);

        ApiService::_success(array(
            'today_issues' => $today_issues,
            'delayed_issues' => $delayed_issues,
            'trackable_issues' => $trackable_issues,
            'users_count' => $users_count,
            'boards_count' => $boards_count,
            'total_hours' => $totalHours
        ));
    }
}
