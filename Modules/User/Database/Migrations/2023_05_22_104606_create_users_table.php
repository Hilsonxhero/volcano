<?php

use Modules\User\Enums\UserStatus;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('ip')->nullable();
            $table->bigInteger('point')->default(0);
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default(UserStatus::ACTIVE->value)->default(UserStatus::ACTIVE->value);
            $table->string('job')->nullable();
            $table->string('bio')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('is_superuser')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
