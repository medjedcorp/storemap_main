<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('industries')->insert([
          ['industry_name' => '飲食店'],
          ['industry_name' => 'アパレル'],
          ['industry_name' => '食料品'],
          ['industry_name' => '医薬品・化粧品'],
          ['industry_name' => '本'],
          ['industry_name' => '家電'],
          ['industry_name' => '工具・DIY'],
          ['industry_name' => 'ペット'],
          ['industry_name' => '雑貨'],
          ['industry_name' => 'イベント物販'],
          ['industry_name' => '総合小売店'],
          ['industry_name' => 'その他小売'],
          ['industry_name' => '医療'],
          ['industry_name' => '宿泊'],
          ['industry_name' => '理容・美容'],
          ['industry_name' => 'エステ・ネイル・マッサージ'],
          ['industry_name' => '運動'],
          ['industry_name' => '教育'],
          ['industry_name' => '不動産'],
          ['industry_name' => '金融保険'],
          ['industry_name' => '建築'],
          ['industry_name' => '自動車・バイク'],
          ['industry_name' => '運輸'],
          ['industry_name' => '娯楽'],
          ['industry_name' => '通信'],
          ['industry_name' => '写真'],
          ['industry_name' => '冠婚葬祭'],
          ['industry_name' => '旅行'],
          ['industry_name' => 'リサイクル'],
          ['industry_name' => '美術館・博物館'],
          ['industry_name' => '動物園、水族館'],
          ['industry_name' => '遊園地'],
          ['industry_name' => '寺社仏閣'],
      ]);
    }
}
