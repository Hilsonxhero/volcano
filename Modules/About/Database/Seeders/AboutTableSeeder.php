<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AboutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = array(
            ['name' => "title", 'value' => json_encode('sample title')],
            ['name' => "subtitle", 'value' => json_encode('sample title')],
            ['name' => "content", 'value' => json_encode('sample about  content')],
            ['name' => "cover", 'value' => json_encode(asset('assets/media/statics/about.svg'))],
        );

        settingRepo()->insert($data);

        // $this->call("OthersTableSeeder");
    }
}
