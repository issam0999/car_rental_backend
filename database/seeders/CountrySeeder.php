<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['id' => 2, 'name_ar' => 'الإمارات العربية المتحدة', 'name' => ' United Arab Emirates'],
            ['id' => 7, 'name_ar' => 'أرمينيا', 'name' => ' Armenia'],
            ['id' => 12, 'name_ar' => 'النمسا', 'name' => ' Austria'],
            ['id' => 13, 'name_ar' => 'أستراليا', 'name' => ' Australia'],
            ['id' => 19, 'name_ar' => 'بنجلاديش', 'name' => ' Bangladesh'],
            ['id' => 20, 'name_ar' => 'بلجيكا', 'name' => ' Belgium'],
            ['id' => 23, 'name_ar' => 'البحرين', 'name' => ' Bahrain'],
            ['id' => 31, 'name_ar' => 'البرازيل', 'name' => ' Brazil'],
            ['id' => 38, 'name_ar' => 'كندا', 'name' => ' Canada'],
            ['id' => 40, 'name_ar' => 'الكونغو - كينشاسا', 'name' => ' Democratic Republic of the Congo'],
            ['id' => 43, 'name_ar' => 'سويسرا', 'name' => ' Switzerland'],
            ['id' => 44, 'name_ar' => 'ساحل العاج', 'name' => ' Cote d ivoire (Ivory Coast)'],
            ['id' => 47, 'name_ar' => 'الكاميرون', 'name' => ' Cameroon'],
            ['id' => 48, 'name_ar' => 'الصين', 'name' => ' China'],
            ['id' => 55, 'name_ar' => 'قبرص', 'name' => ' Cyprus'],
            ['id' => 57, 'name_ar' => 'ألمانيا', 'name' => ' Germany'],
            ['id' => 59, 'name_ar' => 'الدانمرك', 'name' => ' Denmark'],
            ['id' => 62, 'name_ar' => 'الجزائر', 'name' => ' Algeria'],
            ['id' => 65, 'name_ar' => 'مصر', 'name' => ' Egypt'],
            ['id' => 68, 'name_ar' => 'إسبانيا', 'name' => ' Spain'],
            ['id' => 69, 'name_ar' => 'إثيوبيا', 'name' => ' Ethiopia'],
            ['id' => 70, 'name_ar' => 'فنلندا', 'name' => ' Finland'],
            ['id' => 75, 'name_ar' => 'فرنسا', 'name' => ' France'],
            ['id' => 76, 'name_ar' => 'الجابون', 'name' => ' Gabon'],
            ['id' => 77, 'name_ar' => 'المملكة المتحدة', 'name' => ' United Kingdom'],
            ['id' => 79, 'name_ar' => 'جورجيا', 'name' => ' Georgia'],
            ['id' => 82, 'name_ar' => 'غانا', 'name' => ' Ghana'],
            ['id' => 86, 'name_ar' => 'غينيا', 'name' => ' Guinea'],
            ['id' => 89, 'name_ar' => 'اليونان', 'name' => ' Greece'],
            ['id' => 101, 'name_ar' => 'أندونيسيا', 'name' => ' Indonesia'],
            ['id' => 104, 'name_ar' => 'الهند', 'name' => ' India'],
            ['id' => 106, 'name_ar' => 'العراق', 'name' => ' Iraq'],
            ['id' => 107, 'name_ar' => 'إيران', 'name' => ' Iran'],
            ['id' => 109, 'name_ar' => 'إيطاليا', 'name' => ' Italy'],
            ['id' => 112, 'name_ar' => 'الأردن', 'name' => ' Jordan'],
            ['id' => 113, 'name_ar' => 'اليابان', 'name' => ' Japan'],
            ['id' => 114, 'name_ar' => 'كينيا', 'name' => ' Kenya'],
            ['id' => 121, 'name_ar' => 'كوريا الجنوبية', 'name' => ' South Korea'],
            ['id' => 122, 'name_ar' => 'الكويت', 'name' => ' Kuwait'],
            ['id' => 126, 'name_ar' => 'لبنان', 'name' => ' Lebanon'],
            ['id' => 129, 'name_ar' => 'سريلانكا', 'name' => ' Sri Lanka'],
            ['id' => 130, 'name_ar' => 'ليبيريا', 'name' => ' Liberia'],
            ['id' => 133, 'name_ar' => 'لوكسمبورغ', 'name' => ' Luxembourg'],
            ['id' => 135, 'name_ar' => 'ليبيا', 'name' => ' Libya'],
            ['id' => 136, 'name_ar' => 'المغرب', 'name' => ' Morocco'],
            ['id' => 137, 'name_ar' => 'موناكو', 'name' => ' Monaco'],
            ['id' => 139, 'name_ar' => 'الجبل الأسود', 'name' => ' Montenegro'],
            ['id' => 156, 'name_ar' => 'المكسيك', 'name' => ' Mexico'],
            ['id' => 157, 'name_ar' => 'ماليزيا', 'name' => ' Malaysia'],
            ['id' => 158, 'name_ar' => 'موزمبيق', 'name' => ' Mozambique'],
            ['id' => 163, 'name_ar' => 'نيجيريا', 'name' => ' Nigeria'],
            ['id' => 165, 'name_ar' => 'هولندا', 'name' => ' Netherlands'],
            ['id' => 166, 'name_ar' => 'النرويج', 'name' => ' Norway'],
            ['id' => 171, 'name_ar' => 'عُمان', 'name' => ' Oman'],
            ['id' => 176, 'name_ar' => 'الفلبين', 'name' => ' Phillipines'],
            ['id' => 177, 'name_ar' => 'باكستان', 'name' => ' Pakistan'],
            ['id' => 178, 'name_ar' => 'بولندا', 'name' => ' Poland'],
            ['id' => 182, 'name_ar' => 'فلسطين', 'name' => ' Palestine'],
            ['id' => 186, 'name_ar' => 'قطر', 'name' => ' Qatar'],
            ['id' => 188, 'name_ar' => 'رومانيا', 'name' => ' Romania'],
            ['id' => 189, 'name_ar' => 'صربيا', 'name' => ' Serbia'],
            ['id' => 190, 'name_ar' => 'روسيا', 'name' => ' Russia'],
            ['id' => 192, 'name_ar' => 'المملكة العربية السعودية', 'name' => ' Saudi Arabia'],
            ['id' => 195, 'name_ar' => 'السودان', 'name' => ' Sudan'],
            ['id' => 196, 'name_ar' => 'السويد', 'name' => ' Sweden'],
            ['id' => 197, 'name_ar' => 'سنغافورة', 'name' => ' Singapore'],
            ['id' => 211, 'name_ar' => 'سوريا', 'name' => ' Syria'],
            ['id' => 214, 'name_ar' => 'تشاد', 'name' => ' Chad'],
            ['id' => 216, 'name_ar' => 'توجو', 'name' => ' Togo'],
            ['id' => 217, 'name_ar' => 'تايلاند', 'name' => ' Thailand'],
            ['id' => 222, 'name_ar' => 'تونس', 'name' => ' Tunisia'],
            ['id' => 223, 'name_ar' => 'تونغا', 'name' => ' Tonga'],
            ['id' => 224, 'name_ar' => 'تركيا', 'name' => ' Turkey'],
            ['id' => 227, 'name_ar' => 'تايوان', 'name' => ' Taiwan'],
            ['id' => 228, 'name_ar' => 'تانزانيا', 'name' => ' Tanzania'],
            ['id' => 229, 'name_ar' => 'أوكرانيا', 'name' => ' Ukraine'],
            ['id' => 232, 'name_ar' => 'الولايات المتحدة', 'name' => ' United States'],
            ['id' => 233, 'name_ar' => 'أورغواي', 'name' => ' Uruguay'],
            ['id' => 240, 'name_ar' => 'فيتنام', 'name' => ' Vietnam'],
            ['id' => 244, 'name_ar' => 'اليمن', 'name' => ' Yemen'],
            ['id' => 246, 'name_ar' => 'جنوب أفريقيا', 'name' => ' South Africa'],
        ];

        DB::table('countries')->insert($countries);

    }
}
