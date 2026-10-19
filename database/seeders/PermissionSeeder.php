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
                'name_fa' => ' کارکونکی جوړول',
                'guard_name' => 'web',
            ],
            // Suspect 
            [
                'name' => 'Suspect Section',
                'name_fa' => 'د مظنونینو برخه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Save New Suspect Section',
                'name_fa' => 'د نوی مظنون ثبتولو برخه',
                'guard_name' => 'web',
            ],


            [
                'name' => 'Save New Suspect',
                'name_fa' => 'د نوی مظنون ثبتول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Suspect Details',
                'name_fa' => 'د مظنون جزئیاتو مشاهده',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Suspect',
                'name_fa' => 'د مظنون معلوماتو تغیرول',
                'guard_name' => 'web',
            ],


            [
                'name' => 'Release Suspect',
                'name_fa' => 'د مظنون رها کول',
                'guard_name' => 'web',
            ],
            [
                'name' => ' List of Release or Transfer Suspects',
                'name_fa' => 'د رهایی یا انتقال مظنونینو لیست',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Release or Transfer Suspect Details',
                'name_fa' => 'د رهایی یا انتقال مظنونینو جزئیاتو مشاهده',
                'guard_name' => 'web',
            ],


            [
                'name' => 'Add Suspect Release Reference Section',
                'name_fa' => 'د مظنونینو مرجع اضافه کولو بخش',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Save New Suspect Reference',
                'name_fa' => 'د نوی مرجع اضافه کول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Suspect Reference',
                'name_fa' => 'د مظنونینو مرجع تغیرول',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Report Mangement Section',
                'name_fa' => 'د راپورنو مدیریت برخه',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Report Section',
                'name_fa' => 'راپورنو برخه ',
                'guard_name' => 'web',
            ],

            [
                'name' => ' Create Suspects Genral Report',
                'name_fa' => ' د مظنونینو عمومی راپور',
                'guard_name' => 'web',
            ],
            [
                'name' => ' Create Suspects Existing Report',
                'name_fa' => 'د موجودو مظنونینو راپور',
                'guard_name' => 'web',
            ],
            // Users
            [
                'name' => 'Create Release or Transfer Suspcets Report',
                'name_fa' => 'د رهایی یا انتقال مظنونینو راپور',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Suspects Mothly Report',
                'name_fa' => 'د مظنونینو میاشتنی راپور',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Users',
                'name_fa' => 'د کاروونکو معلوماتو تغیرول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Livelihood Manegement Section',
                'name_fa' => 'بدل اعاشه مدیریت برخه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Livelihood Manegement',
                'name_fa' => ' بدل اعاشه مدیریت',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Livelihood Plan',
                'name_fa' => 'د بدل اعاشه پلان جوړول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'List of Livelihood Plans',
                'name_fa' => 'د بدل اعاشې لیست او راپور',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Livelihood Plan Details',
                'name_fa' => 'د بدل اعاشه پلان جزئیاتو مشاهده',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Monthly Livelihood Report',
                'name_fa' => 'د بدل اعاشې میاشتنی راپور جوړول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Make Weekly Livelihood Report',
                'name_fa' => 'د بدل اعاشه هفتنی راپور جوړول',
                'guard_name' => 'web',
            ],

            // ==========================================
            // ⭐ د اجناسو د بیلونو (Goods Invoices) اجازې
            // ==========================================
            [
                'name' => 'Goods Invoices Section',
                'name_fa' => 'د اجناسو د بیلونو مدیریت برخه',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Goods Invoices Management',
                'name_fa' => 'د اجناسو د بیلونو مدیریت',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create Goods Invoice',
                'name_fa' => 'د اجناسو نوی بیل ثبتول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'List Goods Invoices',
                'name_fa' => 'د اجناسو د بیلونو لیست لیدل',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Goods Invoice Details',
                'name_fa' => 'د اجناسو د بیل تفصیلات لیدل',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Goods Invoice',
                'name_fa' => 'د اجناسو د بیل معلوماتو تغیرول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Goods Invoice',
                'name_fa' => 'د اجناسو بیل حذف کول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Change Goods Invoice Status',
                'name_fa' => 'د اجناسو د بیل حالت بدلول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Goods Invoice Image',
                'name_fa' => 'د اجناسو د بیل عکس حذف کول',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Goods Invoice Reports',
                'name_fa' => 'د اجناسو د بیلونو راپور',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Print Goods Invoice Reports',
                'name_fa' => 'د اجناسو د بیلونو راپور چاپ',
                'guard_name' => 'web',
            ],
        ];

        foreach ($data as $value) {
            Permission::updateOrCreate(
                [
                    'name' => $value['name'],
                    'guard_name' => $value['guard_name']
                ],
                [
                    'name_fa' => $value['name_fa']
                ]
            );
        }
    }
}
