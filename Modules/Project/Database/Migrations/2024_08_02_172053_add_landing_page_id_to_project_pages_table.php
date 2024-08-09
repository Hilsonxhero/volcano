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
        Schema::table('project_pages', function (Blueprint $table) {
            $table->foreignId("landing_page_id")->constrained("project_landing_pages")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_pages', function (Blueprint $table) {
            $table->dropColumn("landing_page_id");
        });
    }
};
