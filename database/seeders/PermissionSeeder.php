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
            [
                'name' => 'Create Users',
                'name_fa' => 'ایجاد کاربران',
                'guard_name' => 'web',
            ],
            // Suspect 
            [
                'name' => 'Suspect Section',
                'name_fa' => 'بخش مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Save New Suspect Section',
                'name_fa' => 'ثبت بخش مظنونین جدید',
                'guard_name' => 'web',
            ],


            [
                'name' => 'Save New Suspect',
                'name_fa' => 'ثبت مظنون جدید',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Suspect Details',
                'name_fa' => 'مشاهده جزئیات مظنون',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Suspect',
                'name_fa' => 'تغییر مظنون',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Suspect',
                'name_fa' => 'حذف مظنون',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Release Suspect',
                'name_fa' => 'رها کردن مظنون',
                'guard_name' => 'web',
            ],
            [
                'name' => ' List of Release or Transfer Suspects',
                'name_fa' => 'لیست رهایی و انتقال مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Release or Transfer Suspect Details',
                'name_fa' => 'مشاهده جزئیات مظنون رهایی یا انتقال ',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Release or Transfer Suspect',
                'name_fa' => 'حذف مظنون رهایی یا انتقال',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Add Suspect Release Reference Section',
                'name_fa' => 'بخش اضافه کردن مراجع مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Save New Suspect  Reference',
                'name_fa' => 'ثبت مرجع مظنون',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Suspect Reference',
                'name_fa' => 'تغییر مرجع مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Suspect Reference',
                'name_fa' => 'حذف مرجع مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Report Mangement Section',
                'name_fa' => 'بخش مدیریت راپورها',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Report Section',
                'name_fa' => 'بخش راپور',
                'guard_name' => 'web',
            ],

            [
                'name' => ' Create Suspects Genral Report',
                'name_fa' => ' راپور عمومی مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => ' Create Suspects Existing Report',
                'name_fa' => 'راپور موجودی مظنونین',
                'guard_name' => 'web',
            ],
            // Users
            [
                'name' => 'Create Release or Transfer Suspcets Report',
                'name_fa' => 'راپور مظنونین رهایی یا انتقال ',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Suspects Mothly Report',
                'name_fa' => 'ایجاد راپور ماهانه مظنونین',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Users',
                'name_fa' => 'تغییر کارمندان',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Livelihood Manegement Section',
                'name_fa' => 'بخش مدیریت بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Livelihood Manegement',
                'name_fa' => ' مدیریت بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Livelihood Plan',
                'name_fa' => 'ایجاد پلان بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'List of Livelihood Plans',
                'name_fa' => 'لیست پلان های بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Livelihood Plan Details',
                'name_fa' => 'مشاهده تفاصیل پلان بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Monthly Livelihood Report',
                'name_fa' => 'ایجاد راپور ماهانه بدل اعاشه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Weekly Livelihood Report',
                'name_fa' => 'ایجاد راپور هفتانه بدل اعاشه',
                'guard_name' => 'web',
            ]
        ];
        foreach ($data as $key => $value) {
            Permission::create($value);
        }
    }
}
