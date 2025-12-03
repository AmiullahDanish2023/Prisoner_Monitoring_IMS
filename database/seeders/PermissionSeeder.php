<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                  // Book and Articals
            [
                'name' => 'List of Book or Artical',
                'name_fa' => 'لیست کتاب ها و مقاله ها',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Book or Artical',
                'name_fa' => 'ثبت کتاب ها و مقاله ها',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Book or Artical',
                'name_fa' => 'تغییر کتاب ها و مقاله ها',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Book or Artical',
                'name_fa' => 'حذب کتاب ها و مقاله ها',
                'guard_name' => 'web',
            ],
                    // Conference
            [
                'name' => 'List of Conference',
                'name_fa' => 'لیست کانفرانس',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Conference',
                'name_fa' => 'ثبت کانفراس',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Conference',
                'name_fa' => 'تغییر کانفرانس',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Conference',
                'name_fa' => 'حذب کانفرانس',
                'guard_name' => 'web',
            ],
                // Doctors
            [
                'name' => 'List of Doctor',
                'name_fa' => 'لیست داکتران',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Doctor',
                'name_fa' => 'ثبت داکتر',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Doctor',
                'name_fa' => 'تغییر داکتر',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Doctor',
                'name_fa' => 'حذب داکتر',
                'guard_name' => 'web',
            ],
                // About
            [
                'name' => 'Edit About',
                'name_fa' => 'تغییرات در درباره',
                'guard_name' => 'web',
            ],
                // Contact
            [
                'name' => 'List of Contact',
                'name_fa' => 'لیست تماس ها ',
                'guard_name' => 'web',
            ],
                    // Setting
            [
                'name' => 'Edit Setting',
                'name_fa' => 'تغییرات در تنظیمات',
                'guard_name' => 'web',
            ],
                // Users
            [
                'name' => 'Users',
                'name_fa' => 'کارمندان',
                'guard_name' => 'web',
            ],[
                'name' => 'Create Users',
                'name_fa' => 'ایجاد کارمندان',
                'guard_name' => 'web',
            ],[
                'name' => 'Edit Users',
                'name_fa' => 'تغییر کارمندان',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Announcement',
                'name_fa' => 'تغییر اطلاعیه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'List Department',
                'name_fa' => 'لیست دیپارتمنت',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Department',
                'name_fa' => 'ثبت دیپارتمنت',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Department',
                'name_fa' => 'تغییر دیپارتمنت',
                'guard_name' => 'web',
            ]
        ];
        foreach ($data as $key => $value) {
            Permission::create($value);
        }
    }
}
