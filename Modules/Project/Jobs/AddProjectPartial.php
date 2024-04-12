<?php

namespace Modules\Project\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Modules\Common\Enums\CommonStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Project\Entities\ProjectTimeCategory;
use Modules\Project\Enums\ProjectTimeCategoryStatus;

class AddProjectPartial
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $project;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = array(
            array(
                'title' => "طراحی",
                'is_default' => false,
                'project_id' => $this->project->id,
                'status' => ProjectTimeCategoryStatus::ACTIVE->value,
            ),
            array(
                'title' => "توسعه",
                'is_default' => false,
                'project_id' => $this->project->id,
                'status' => ProjectTimeCategoryStatus::ACTIVE->value,
            )
        );

        projectTimeCategoryRepo()->insert($data);


        $data = array(
            array(
                'title' => "پشتیبانی",
                'description' => "پشتیبانی",
                "slug" =>  Str::slug("پشتیبانی", '-', null),
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "ایراد",
                'description' => "ایراد",
                "slug" =>  Str::slug("ایراد", '-', null),
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "قابلیت",
                'description' => "قابلیت",
                "slug" =>  Str::slug("قابلیت", '-', null),
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
        );
        projectTrackerRepo()->insert($data);

        $data = array(
            array(
                'title' => "حل شده",
                'description' => "حل شده",
                'is_closed' => false,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "جدید",
                'description' => "جدید",
                'is_closed' => false,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "در حال انجام",
                'description' => "در حال انجام",
                'is_closed' => false,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "بازخورد",
                'description' => "بازخورد",
                'is_closed' => false,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "بسته",
                'description' => "بسته",
                'is_closed' => true,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
            array(
                'title' => "ردشده",
                'description' => "ردشده",
                'is_closed' => true,
                'project_id' => $this->project->id,
                'status' => CommonStatus::ACTIVE->value,
            ),
        );
        projectIssueStatusRepo()->insert($data);
    }
}
