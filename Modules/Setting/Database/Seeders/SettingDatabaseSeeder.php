<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingDatabaseSeeder extends Seeder
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
            ['name' => "site_name", 'value' => json_encode('test')],
            ['name' => "site_description", 'value' => json_encode("test")],
            ['name' => "home_title", 'value' => json_encode('test')],
            ['name' => "home_description", 'value' => json_encode("test")],
            ['name' => "email", 'value' => json_encode("info@volcano.com")],
            ['name' => "phone", 'value' => json_encode("021454323")],
            ['name' => "mobile", 'value' => json_encode("09011112233")],
            ['name' => "address", 'value' => json_encode("test")],
            ['name' => "copyright", 'value' => json_encode("test")],
            ['name' => "logo_light", 'value' => json_encode(asset('assets/media/statics/logo-light.svg'))],
            ['name' => "logo_dark", 'value' => json_encode(asset('assets/media/statics/logo-dark.svg'))],
            ['name' => "socialmedia", 'value' => json_encode([
                ["name" => "telegram", "title" => "https://sample.info"],
                ["name" => "instagram", "title" => "https://sample.info"],
                ["name" => "twitter", "title" => "https://sample.info"],
                ["name" => "meta", "title" => "https://sample.info"],
            ])],
        );

        settingRepo()->insert($data);
        // $this->call("OthersTableSeeder");
    }
}
