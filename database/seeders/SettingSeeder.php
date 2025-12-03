<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
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
            'name' => 'General Directorate of Police Health Affairs',
            'location' => 'Kabul, Afghanistan',
            'main_text' => 'In this meeting, the Minister of Interior Affairs, while inquiring about the well-being and hearing the issues of patients, stated that the people of Afghanistan take pride in the brave and courageous forces of the country. These forces, like loyal sons of the nation, have spared no effort or sacrifice in protecting the lives and property of the people, even shedding their blood. The Minister of Interior Affairs has allocated financial assistance to the patients and wounded in hospitals, specifically donating three hundred beds to the police hospital. In order to ensure the best possible treatment for the patients, necessary instructions have been given by the Minister of Interior Affairs to the officials of that hospital. .',
            'email' => 'contact@example.com',
            'number' => '0779090890',
            'logo' => 'frontend/logo/moi_logo.png',
            'facebook_link' => 'https://www.facebook.com/',
            'instagram_link' => 'https://www.instagram.com/',
            'twiter_link' => 'https://x.com/',
            'linkedin_link' => 'https://af.linkedin.com/',
            'language_id' => '1',
        ],[
            'name' => 'پولیسو د روغتیا د چارو عمومي ریاست',
            'location' => 'کابل، افغانستان',
            'email' => 'contact@example.com',
            'main_text' => 'په دې کتنه کې د کورنیو چارو وزیر د ناروغانو د ښه راغلاست او د هغوی د ستونزو د اورېدو په ترڅ کې وویل، افغان ملت د هېواد په زړورو او زړورو ځواکونو ویاړي او دغه ځواکونه د هېواد د رښتیني بچیانو په توګه هېڅ ډول هڅې نه سپموي. ترڅو د خپلو وینو په تویولو سره د خلکو د ژوند او مال ساتنه وکړي. د کورنیو چارو وزیر د پولیسو په ۳۰۰ بستریز روغتون کې ناروغانو او ټپیانو ته نغدي ډالۍ ورکړې او د ناروغانو د ښې درملنې په موخه یې د روغتون مسوولینو ته لازمې لارښوونې وکړې. د يو بل خبر له مخې: د کورنيو چارو وزير سراج الدين حقاني نن سهار د ساحوي زونونو او امنيه قوماندانۍ له قوماندانانو سره د ويډيو کنفرانس له لارې خبرې وکړې.',
            'number' => '0779090890',
            'logo' => 'frontend/logo/moi_logo.png',
            'facebook_link' => 'https://www.facebook.com/',
            'instagram_link' => 'https://www.instagram.com/',
            'twiter_link' => 'https://x.com/',
            'linkedin_link' => 'https://af.linkedin.com/',
            'language_id' => '2',
        ],[
            'name' => 'ریاست عمومی امور صحی پولیس',
            'location' => 'کابل، افغانستان',
            'email' => 'contact@example.com',
            'main_text' => 'درین دیداروزیرامورداخله ضمن احوال پرسی وشنیدن مشکلات مریضان گفت که ملت افغانستان به نیروهای دلیر وشجاع کشور افتخارنموده و این نیروها به مثابه فرزندان صدیق کشور درراستای حراست ازجان ومال مردم با ریختاندن خون شان از هیچگونه سعی و تلاشی دریغ نکرده اند. وزیر امورداخله تحایف نقدی را به مریضان ومجروحین داخل بستردرشفاخانه سه صد بسترپولیس اهدا نموده وبه منظورمعالجه وتداوی هرچه بهترمریضان، ازسوی وزیر امورداخله به مسوولین آن شفاخانه هدایت لازم داده شد . بر مبنای یک خبر دیگر: سراج الدین حقانی وزیر امورداخله، صبح امروز از طریق ویدیو کنفرانس به قوماندانان زون های ساحوی و قوماندانی امنیه ولایات هدایت داد تا روی تامین امنیت روزهای عید تدابیر لازم را روی دست گیرند. وزیر امورداخله عید سعید فطر را به تمام منسوبین پولیس ملی که مصروف وظایف هستند تبریک وتهنیت گفته به آنها هدایت داد تا در جهت تامین امنیت بهتر ایام عید بیشتر تلاش نمایند.',
            'number' => '0779090890',
            'logo' => 'frontend/logo/moi_logo.png',
            'facebook_link' => 'https://www.facebook.com/',
            'instagram_link' => 'https://www.instagram.com/',
            'twiter_link' => 'https://x.com/',
            'linkedin_link' => 'https://af.linkedin.com/',
            'language_id' => '3',
        ]
    ];
    foreach ($data as $key => $value) {
        Setting::create($value);
    }
    }
}
