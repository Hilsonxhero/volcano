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
        Schema::create('project_time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->nullable()->constrained('projects')->cascadeOnDelete();
            $table->foreignId("project_issue_id")->nullable()->constrained('project_issues')->cascadeOnDelete();
            $table->foreignId("project_time_category_id")->nullable()->constrained('project_time_categories')->cascadeOnDelete();
            $table->foreignId("user_id")->nullable()->constrained('users')->cascadeOnDelete();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->timestamp("spent_on");
            $table->string("hours");
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
        Schema::dropIfExists('project_time_entries');
    }
};
