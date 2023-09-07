<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->nullable()->constrained('projects')->cascadeOnDelete();
            $table->foreignId("project_issue_status_id")->nullable()->constrained('project_issue_statuses')->cascadeOnDelete();
            $table->foreignId("project_tracker_id")->nullable()->constrained('project_trackers')->cascadeOnDelete();
            $table->foreignId("creator_id")->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId("assigned_to_id")->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId("priority_id")->nullable()->constrained('project_priorities')->cascadeOnDelete();
            $table->string("title");
            $table->text("description")->nullable();
            $table->text("note")->nullable();
            $table->timestamp("start_date");
            $table->timestamp("end_date")->nullable();
            $table->string("estimated_hours")->nullable();
            $table->string("done_ratio");
            $table->string("status");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_issues');
    }
};
