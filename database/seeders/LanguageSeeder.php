<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'name' => 'en',
            'type' => '1'
        ],[
            'name' => 'pa',
            'type' => '2'
        ],[
            'name' => 'fa',
            'type' => '3'
        ]
    ];
    foreach ($data as $key => $value) {
        Language::create($value);
    }
    }
}
