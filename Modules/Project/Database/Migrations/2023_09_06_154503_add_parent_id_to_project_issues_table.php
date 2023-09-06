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
        Schema::table('project_issues', function (Blueprint $table) {
            $table->foreignId("parent_id")->nullable()->after('project_priority_id')->constrained('project_issues')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_issues', function (Blueprint $table) {
            $table->dropColumn("parent_id");
        });
    }
};
