<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
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
            'name_ps' => 'د سیستمو مدیریت',
            'name_dr' => 'مدیریت سیستم ها',
        ],[
            'name_ps' => 'د اکمال مدیریت',
            'name_dr' => 'مدیریت اکمال',
        ]
    ];
    foreach ($data as $key => $value) {
        Department::create($value);
    }
    }
}
