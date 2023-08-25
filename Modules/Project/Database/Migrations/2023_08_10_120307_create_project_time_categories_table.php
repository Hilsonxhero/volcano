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
        Schema::create('project_time_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->nullable()->constrained('projects')->cascadeOnDelete();
            $table->string("title");
            $table->boolean("is_default");
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
        Schema::dropIfExists('project_time_categories');
    }
};
