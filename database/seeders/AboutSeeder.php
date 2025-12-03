<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
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
            'title' => 'Public Hospitals in Delivering Accessible Healthcare',
            'description' => 'Public hospitals play a crucial role in providing accessible and affordable healthcare services to communities across the country. These facilities are funded and operated by the government, ensuring that all citizens, regardless of their financial status, can receive the medical attention they need. Public hospitals often serve as the primary healthcare providers for low-income and underserved populations, offering a wide range of services including emergency care, outpatient clinics, and specialized treatments.
            These institutions are staffed by highly trained medical professionals, including doctors, nurses, and support staff, who are dedicated to delivering high-quality care to their patients. Public hospitals also serve as important hubs for medical research and training, providing opportunities for medical students and residents to gain hands-on experience and contributing to the advancement of healthcare knowledge and practices.
            Despite the important role they play, public hospitals often face challenges in terms of funding, resources, and capacity, as they strive to meet the growing demand for their services. Policymakers and healthcare stakeholders must work to ensure that these vital institutions have the necessary support and infrastructure to continue fulfilling their mission of providing accessible and equitable healthcare to all members of the community.',
            'language_id' => '1',
            'video_link' => 'https://youtu.be/Ci7I92shHiw?si=Hng6j16zkCWZzoJY',
            'image' => 'frontend/images/about1.jpg',
        ],[
            'title' => 'د لاسرسي وړ روغتیا پاملرنې وړاندې کولو کې عامه روغتونونه',
            'description' => 'عامه روغتونونه په ټول هیواد کې ټولنو ته د لاسرسي وړ او ارزانه روغتیایی خدماتو په وړاندې کولو کې مهم رول لوبوي. دا تاسیسات د حکومت لخوا تمویل او چلول کیږي، ډاډ ترلاسه کوي چې ټول اتباع، پرته له دې چې د دوی مالي حالت ته پام وکړي، کولی شي طبي پاملرنې ترلاسه کړي چې دوی ورته اړتیا لري. عامه روغتونونه اکثرا د ټیټ عاید او کم مصرف شوي خلکو لپاره د لومړني روغتیا پاملرنې چمتو کونکي په توګه خدمت کوي ، د بیړني پاملرنې ، بهر ناروغانو کلینیکونو ، او تخصصي درملنې په شمول پراخه خدمات وړاندې کوی. دا موسسې د لوړ روزل شوي طبي متخصصینو لخوا کارکونکي دي، پشمول د ډاکټرانو، نرسانو، او مالتړ کارمندانو، چې خپلو ناروغانو ته د لوړ کیفیت پاملرنې وړاندې کولو لپاره وقف شوي دي. عامه روغتونونه د طبي څیړنې او روزنې لپاره د مهم مرکز په توګه هم کار کوي، د طبي زده کونکو او اوسیدونکو لپاره فرصتونه چمتو کوي چې لاس په کار تجربه ترلاسه کړي او د روغتیا پاملرنې پوهې او کړنو پرمختګ کې مرسته وکړی. د هغه مهم رول سره سره چې دوی یې لوبوي، عامه روغتونونه اکثرا د تمویل، سرچینو او ظرفیت له پلوه له ننګونو سره مخ دي، ځکه چې دوی هڅه کوي د دوی د خدماتو مخ په زیاتیدونکي غوښتنې پوره کړي. پالیسي جوړونکي او د روغتیا پاملرنې برخه اخیستونکي باید کار وکړي ترڅو ډاډ ترلاسه کړي چې دا حیاتي بنسټونه اړین ملاتړ او زیربنا لري ترڅو د ټولنې ټولو غړو ته د لاسرسي وړ او مساوي روغتیا پاملرنې چمتو کولو خپل ماموریت ته دوام ورکړي...',
            'language_id' => '2',
            'video_link' => 'https://youtu.be/Ci7I92shHiw?si=Hng6j16zkCWZzoJY',
            'image' => 'frontend/images/about1.jpg',
        ],[
            'title' => 'بیمارستان های دولتی در ارائه مراقبت های بهداشتی در دسترس ',
            'description' => 'بیمارستان های دولتی نقش مهمی در ارائه خدمات بهداشتی در دسترس و مقرون به صرفه به جوامع سراسر کشور دارند. این تسهیلات توسط دولت تأمین مالی و بهره برداری می شود و تضمین می کند که همه شهروندان، صرف نظر از وضعیت مالی خود، می توانند مراقبت های پزشکی مورد نیاز خود را دریافت کنند. بیمارستان های دولتی اغلب به عنوان ارائه دهندگان مراقبت های بهداشتی اولیه برای جمعیت های کم درآمد و محروم عمل می کنند و طیف گسترده ای از خدمات از جمله مراقبت های اورژانسی، کلینیک های سرپایی و درمان های تخصصی را ارائه می  این موسسات توسط متخصصان پزشکی بسیار آموزش دیده، از جمله پزشکان، پرستاران، و کارکنان پشتیبانی، که به ارائه خدمات با کیفیت بالا به بیماران خود اختصاص داده شده اند، تشکیل شده اند. بیمارستان‌های دولتی همچنین به‌عنوان مراکز مهمی برای تحقیقات و آموزش پزشکی عمل می‌کنند و فرصت‌هایی را برای دانشجویان و دستیاران پزشکی فراهم می‌کنند تا تجربیات عملی کسب کنند و به پیشرفت دانش و شیوه‌های مراقبت‌های بهداشتی کمک کنند. علیرغم نقش مهمی که ایفا می‌کنند، بیمارستان‌های دولتی اغلب با چالش‌هایی از نظر بودجه، منابع و ظرفیت مواجه هستند، زیرا در تلاش برای پاسخگویی به تقاضای رو به رشد برای خدمات خود هستند. سیاست گذاران و ذینفعان مراقبت های بهداشتی باید تلاش کنند تا اطمینان حاصل شود که این نهادهای حیاتی از حمایت و زیرساخت لازم برای ادامه انجام ماموریت خود در ارائه مراقبت های بهداشتی در دسترس و عادلانه برای همه اعضای جامعه برخوردار هستند.',
            'language_id' => '3',
            'video_link' => 'https://youtu.be/Ci7I92shHiw?si=Hng6j16zkCWZzoJY',
            'image' => 'frontend/images/about1.jpg',
        ]
    ];
    foreach ($data as $key => $value) {
        About::create($value);
    }
    }
}
