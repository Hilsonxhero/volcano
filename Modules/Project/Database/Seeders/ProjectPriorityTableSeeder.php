<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectPriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $priorites = array(
            array(
                "title" => "کم",
            ),
            array(
                "title" => "معمولی",
            ),
            array(
                "title" => "زیاد",
            ),
            array(
                "title" => "فوری",
            ),
            array(
                "title" => "بی‌درنگ",
            ),

        );

        projectPriorityRepo()->insert($priorites);
    }
}
