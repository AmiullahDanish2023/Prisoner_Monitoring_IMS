<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
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
            'title' => 'Announcement & News',
            'description' => 'The hospital has announced the launch of a new state-of-the-art cancer treatment center. The center will offer the latest advancements in cancer diagnosis and personalized treatment plans. Patients will have access to cutting-edge radiation therapy, immunotherapy, and targeted drug therapies. The facility was designed with patient comfort in mind, providing a calming and supportive environment. Hospital administrators are excited to bring this innovative cancer care to the community, helping to improve outcomes and quality of life for those affected by this disease.',
            'language_id' => '1',
        ],[
            'title' => 'اطلاعیه',
            'description' => 'روغتون اعلان وکړ چې د سرطان د درملنې یو نوی مرکز یې پرانیستی دی. دا مرکز به د سرطان تشخیص او شخصي درملنې پالنونو کې وروستي پرمختګونه وړاندې کړي. ناروغان به د وړانګو وړانګو درملنې ، معافیتي درملنې ، او هدف لرونکي درملو درملنې ته لاسرسی ولري. دا تاسیسات د ناروغ آرامۍ په ذهن کې ډیزاین شوي، یو آرام او مرستندویه چاپیریال چمتو کوي. د روغتون مدیران خوښ دي چې ټولنې ته د سرطان دا نوښت پاملرنې راوړي، د دې ناروغۍ لخوا اغیزمن شوي د پایلو او د ژوند کیفیت ښه کولو کې مرسته کوي.',
            'language_id' => '2'
        ],[
            'title' => 'اطلاعیه او خبر',
            'description' => 'این بیمارستان از راه اندازی یک مرکز جدید درمانی سرطان خبر داده است. این مرکز آخرین پیشرفت‌ها را در زمینه تشخیص سرطان و طرح‌های درمانی شخصی ارائه می‌دهد. بیماران به پرتودرمانی پیشرفته، ایمونوتراپی و درمان های دارویی هدفمند دسترسی خواهند داشت. این مرکز با در نظر گرفتن راحتی بیمار طراحی شده است و محیطی آرام و حمایتی را فراهم می کند. مدیران بیمارستان برای ارائه این مراقبت های سرطانی نوآورانه به جامعه هیجان زده هستند و به بهبود نتایج و کیفیت زندگی افراد مبتلا به این بیماری کمک می کند.',
            'language_id' => '3'
        ]
    ];
    foreach ($data as $key => $value) {
        Announcement::create($value);
    }
    }
}
