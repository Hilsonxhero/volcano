<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Enums\UserStatus;
use Modules\User\Fields\UserFields;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Make Real Users
        $this->mkSystemAdministrator()
            ->mkProgrammer()
            ->mkRegularUser();
    }

    /**
     * Make System Administrator
     *
     * @return self
     */
    private function mkSystemAdministrator(): self
    {

        $user = userRepo()->create([
            UserFields::USERNAME          => "system_administrator",
            UserFields::EMAIL             => fake()->email(),
            UserFields::PHONE            => fake()->phoneNumber(),
            UserFields::EMAIL_VERIFIED_AT => now(),
            UserFields::IS_SUPERUSER => true,
            UserFields::PASSWORD          => Hash::make("password"),
            UserFields::STATUS            => UserStatus::ACTIVE->value
        ]);
        $user->assignRole('system_administrator');
        return $this;
    }


    /**
     * Make Programmer
     *
     * @return self
     */
    private function mkProgrammer(): self
    {
        $user = userRepo()->create([
            UserFields::USERNAME          => "system_administrator",
            UserFields::EMAIL             => fake()->email(),
            UserFields::PHONE            => fake()->phoneNumber(),
            UserFields::EMAIL_VERIFIED_AT => now(),
            UserFields::IS_SUPERUSER => false,
            UserFields::PASSWORD          => Hash::make("password"),
            UserFields::STATUS            => UserStatus::ACTIVE->value
        ]);

        $user->assignRole('programmer');

        return $this;
    }

    /**
     * Make Regular User
     *
     * @return void
     */
    private function mkRegularUser(): void
    {
        $user = userRepo()->create([
            UserFields::USERNAME          => "system_administrator",
            UserFields::EMAIL             => fake()->email(),
            UserFields::PHONE            => fake()->phoneNumber(),
            UserFields::EMAIL_VERIFIED_AT => now(),
            UserFields::IS_SUPERUSER => false,
            UserFields::PASSWORD          => Hash::make("password"),
            UserFields::STATUS            => UserStatus::ACTIVE->value
        ]);

        $user->assignRole('regular_user');
    }
}
