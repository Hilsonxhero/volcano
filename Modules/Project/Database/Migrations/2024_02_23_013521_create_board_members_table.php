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
        Schema::create('board_members', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->text("token");
            $table->foreignId("user_id")->nullable()->constrained("users")->cascadeOnDelete();
            $table->foreignId("inviter_id")->nullable()->constrained("users")->cascadeOnDelete();
            $table->foreignId("board_id")->nullable()->constrained("boards")->cascadeOnDelete();
            $table->string("role")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('board_members');
    }
};
