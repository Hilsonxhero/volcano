<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Common\Services\ApiService;
use Modules\Project\Entities\ProjectTimeEntry;
use Modules\Project\Repository\Contracts\ProjectRepository;
use Modules\Project\Http\Requests\v1\App\ProjectIssueTimeRequest;

use function PHPUnit\Framework\returnSelf;

class ProjectTimeReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, $project)
    {
        $user = auth()->user();
        $project = projectRepo()->find($project);
        $start_date = $project->created_at;
        $reports = [];
        $interval = $request->interval;
        $start_date = Carbon::parse($project->created_at)->subYears(1);
        // $end_date = Carbon::parse($project->created_at)->addMonth(2)->subYears(6);
        // return Carbon::parse($project->created_at)->subYears(2);
        // return collect(CarbonPeriod::create($start_date, "1 $interval", now()));
        // return $start_date;
        // return collect(CarbonPeriod::create($start_date, "1 $interval", now()));
        $interval_labels = collect(CarbonPeriod::create($start_date, "1 $interval", now()))
            ->map(function ($period_item) use ($interval) {
                $jDate = Jalalian::fromDateTime($period_item);
                switch ($interval) {
                    case 'year':
                        return  $jDate->format('%Y');
                        break;
                    case 'month':
                        return  $jDate->format('Y-m');
                        break;
                    case 'day':
                        return  $jDate->format('Y-m-d');
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->toArray();
        // return $interval_labels;

        // $jDate = Jalalian::fromDateTime("2023-06-09T15:10:23.000000Z");

        // return [$first_month, $end_month] = $this->getFirstAndLastDayOfMonth($jDate->getYear(), $jDate->getMonth());
        foreach ($project->members as $key => $member) {
            $data = collect(CarbonPeriod::create($start_date, "1 $interval", now()->addMonth(1)))
                ->map(function ($period_item, $index) use ($member, $interval) {
                    $jDate = Jalalian::fromDateTime($period_item);
                    [$first_month, $end_month] = $this->getFirstAndLastDayOfMonth($jDate->getYear(), $jDate->getMonth());

                    switch ($interval) {
                        case 'year':
                            $date_format = "Y";
                            $times = ProjectTimeEntry::query()
                                ->where('user_id', '>=', $member->user_id)
                                ->whereYear('created_at', '>=', $first_month)
                                ->whereYear('created_at', '<=', $end_month)
                                ->get();
                            break;
                        case 'month':
                            $date_format = "Y-m";
                            $times = ProjectTimeEntry::query()
                                ->where('user_id', '>=', $member->user_id)
                                ->whereDate('created_at', '>=', $first_month)
                                ->whereDate('created_at', '<=', $end_month)
                                ->get();
                            break;
                        case 'day':
                            $date_format = "Y-m-d";
                            $times = ProjectTimeEntry::query()
                                ->where('user_id', '>=', $member->user_id)
                                ->whereDate('created_at', '=', $period_item)
                                ->get();
                            break;
                        default:
                            # code...
                            break;
                    }

                    $totalHours = $times->reduce(function ($total, $time) {
                        return $total + $time->total_hours;
                    }, 0);
                    // return [$index => sprintf("%02d:%02d", $totalHours / 60, $totalHours % 60)];
                    return ["label" => $jDate->format($date_format), "value" => sprintf("%02d:%02d", $totalHours / 60, $totalHours % 60)];
                })
                ->toArray();

            $total = collect($data)->reduce(function ($total, $time) {
                $totalHours = 0;
                list($hours, $minutes) = explode(':', $time["value"]);
                $totalHours += $hours * 60 + $minutes;
                return $total + $totalHours;
            }, 0);
            $user_report =  array(
                "user" => $member->user->username,
                "values" => $data,
                'total' =>  sprintf("%02d:%02d", $total / 60, $total % 60),
                'start_at' =>  formatGregorian($start_date, "Y/m/d"),
                'end_at' =>  formatGregorian(now(), "Y/m/d")
            );
            array_push($reports, $user_report);
        }

        ApiService::_success(['labels' => $interval_labels, 'values' => $reports]);
    }

    public function getFirstAndLastDayOfMonth($year, $month)
    {
        $date_count = (new Jalalian($year, $month, 1))->getMonthDays();
        $first_month = (new Jalalian($year, $month, 1))->toCarbon();
        $end_month = (new Jalalian($year, $month, $date_count))->toCarbon();
        return [$first_month, $end_month];
    }
}
