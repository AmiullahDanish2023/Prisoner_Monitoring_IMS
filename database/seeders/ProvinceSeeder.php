<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = [
            [
                "name_en" => "Kabul",
                "name_da" => "کابل",
                "name_pa" => "کابل",
            ],
            [
                "name_en" => "Kapisa",
                "name_da" => "کاپيسا",
                "name_pa" => "کاپيسا",
            ],
            [
                "name_en" => "Parwan",
                "name_da" => "پروان",
                "name_pa" => "پروان",
            ],
            [
                "name_en" => "Wardak",
                "name_da" => "میدان وردک",
                "name_pa" => "میدان وردک",
            ],
            [
                "name_en" => "Logar",
                "name_da" => "لوگر",
                "name_pa" => "لوگر",
            ],
            [
                "name_en" => "Ghazni",
                "name_da" => "غزني",
                "name_pa" => "غزني",
            ],
            [
                "name_en" => "Paktia",
                "name_da" => "پکتيا",
                "name_pa" => "پکتيا",
            ],
            [
                "name_en" => "Nangarhar",
                "name_da" => "ننگرهار",
                "name_pa" => "ننگرهار",
            ],
            [
                "name_en" => "Laghman",
                "name_da" => "لغمان",
                "name_pa" => "لغمان",
            ],
            [
                "name_en" => "Kunar",
                "name_da" => "کنر",
                "name_pa" => "کنر",
            ],
            [
                "name_en" => "Badakhshan",
                "name_da" => "بدخشان",
                "name_pa" => "بدخشان",
            ],
            [
                "name_en" => "Takhar",
                "name_da" => "تخار",
                "name_pa" => "تخار",
            ],
            [
                "name_en" => "Baghlan",
                "name_da" => "بغلان",
                "name_pa" => "بغلان",
            ],
            [
                "name_en" => "Kunduz",
                "name_da" => "کندوز",
                "name_pa" => "کندوز",
            ],
            [
                "name_en" => "Samangan",
                "name_da" => "سمنگان",
                "name_pa" => "سمنگان",
            ],
            [
                "name_en" => "Balkh",
                "name_da" => "بلخ",
                "name_pa" => "بلخ",
            ],
            [
                "name_en" => "Jawzjan",
                "name_da" => "جوزجان",
                "name_pa" => "جوزجان",
            ],
            [
                "name_en" => "Faryab",
                "name_da" => "فارياب",
                "name_pa" => "فارياب",
            ],
            [
                "name_en" => "Badghis",
                "name_da" => "بادغيس",
                "name_pa" => "بادغيس",
            ],
            [
                "name_en" => "Herat",
                "name_da" => "هرات",
                "name_pa" => "هرات",
            ],
            [
                "name_en" => "Farah",
                "name_da" => "فراه",
                "name_pa" => "فراه",
            ],
            [
                "name_en" => "Nimroz",
                "name_da" => "نيمروز",
                "name_pa" => "نيمروز",
            ],
            [
                "name_en" => "Hilmand",
                "name_da" => "هلمند",
                "name_pa" => "هلمند",
            ],
            [
                "name_en" => "Kandahar",
                "name_da" => "کندهار",
                "name_pa" => "کندهار",
            ],
            [
                "name_en" => "Zabul",
                "name_da" => "زابل",
                "name_pa" => "زابل",
            ],
            [
                "name_en" => "Uruzgan",
                "name_da" => "ارزگان",
                "name_pa" => "ارزگان",
            ],
            [
                "name_en" => "Ghor",
                "name_da" => "غور",
                "name_pa" => "غور",
            ],
            [
                "name_en" => "Bamyan",
                "name_da" => "باميان",
                "name_pa" => "باميان",
            ],
            [
                "name_en" => "Paktika",
                "name_da" => "پکتيکا",
                "name_pa" => "پکتيکا",
            ],
            [
                "name_en" => "Nuristan",
                "name_da" => "نورستان",
                "name_pa" => "نورستان",
            ],
            [
                "name_en" => "Sar i Pul",
                "name_da" => "سرپل",
                "name_pa" => "سرپل",
            ],
            [
                "name_en" => "Khost",
                "name_da" => "خوست",
                "name_pa" => "خوست",
            ],
            [
                "name_en" => "Panjshir",
                "name_da" => "پنجشير",
                "name_pa" => "پنجشير",
            ],
            [
                "name_en" => "Daikundi",
                "name_da" => "دايکندي",
                "name_pa" => "دايکندي",
            ],
            [
                "name_en" => "Parts and Brochures",
                "name_da" => "قطعات و جزوتام ها",
                "name_pa" => "برخې او بروشرونه",
            ]
        ];

        foreach ($provinces as $province)
            Province::create($province);
    }
}
