<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('companies')->insert([
//        'user_id' => '1',
        'id' => 1,
        'company_name' => 'メジェド合同会社',
        // 'company_code' => 'tophouse',
        'company_kana' => 'めじぇどごうどうがいしゃ',
        'company_postcode' => '639-2155',
        'prefecture' => '奈良県',
        'company_city' => '葛城市',
        'company_adnum' => '竹内218-14',
        'company_apart' => '',
        'company_phone_number' => '090-4285-3303',
      //   'company_fax_number' => '011-111-1111',
        'manager_name' => '松田　智哉',
        'manager_kana' => 'まつだともや',
        'site_url' => 'http://storemap.jp',
        // 'certificate' => 'shoumei.pdf',
        'maker_flag' => '0',
        'img_flag' => '1',
        // 'gs1_company_prefix' => '4527772',
      ]);

      DB::table('companies')->insert([
//        'user_id' => '1',
        'id' => 2,
        'company_name' => '株式会社トップハウス',
        // 'company_code' => 'tophouse',
        'company_kana' => 'かぶしきがいしゃとっぷはうす',
        'company_postcode' => '587-0011',
        'prefecture' => '大阪府',
        'company_city' => '堺市美原区',
        'company_adnum' => '丹上587-3',
        'company_apart' => '',
        'company_phone_number' => '072-362-7080',
        'company_fax_number' => '072-362-7081',
        'manager_name' => '門之園　純博',
        'manager_kana' => 'かどのそのすみひろ',
        'site_url' => 'http://tophouse.jp',
        // 'certificate' => 'shoumei.pdf',
        'maker_flag' => '1',
        'img_flag' => '0',
        'gs1_company_prefix' => '4527772',
      ]);
//       DB::table('companies')->insert([
// //        'user_id' => '1',
//         'id' => 3,
//         'company_name' => '株式会社テストです',
//         // 'company_code' => 'tophouse',
//         'company_kana' => 'てすとです',
//         'company_postcode' => '206-0041',
//         'prefecture' => '東京都',
//         'company_city' => '多摩市',
//         'company_adnum' => '愛宕テスト',
//         'company_apart' => '',
//         'company_phone_number' => '0120-345-678',
//         'company_fax_number' => '03-1234-5678',
//         'manager_name' => '山田　太郎',
//         'manager_kana' => 'やまだたろう',
//         'site_url' => 'http://test.jp',
//         'certificate' => 'shoumei2.pdf',
//         'maker_flag' => '0',
//       ]);
//       factory(App\Models\Company::class, 100)->create();
      }
}
