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
        Schema::table('project_memberships', function (Blueprint $table) {
            $table->foreignId("role_id")->nullable()->constrained("roles")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_memberships', function (Blueprint $table) {
            $table->dropColumn("role_id");
        });
    }
};
