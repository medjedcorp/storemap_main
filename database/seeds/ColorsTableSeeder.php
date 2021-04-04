<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('colors')->insert([
          ['color_list' => 'ホワイト系','color_code' => '#ffffff'],
          ['color_list' => 'ブラック系','color_code' => '#000000'],
          ['color_list' => 'グレー系','color_code' => '#808080'],
          ['color_list' => 'ブラウン系','color_code' => '#A52A2A'],
          ['color_list' => 'カーキ系','color_code' => '#9a753a'],
          ['color_list' => 'ベージュ系','color_code' => '#F5F5DC'],
          ['color_list' => 'ライム系','color_code' => '#00FF00'],
          ['color_list' => 'グリーン系','color_code' => '#008000'],
          ['color_list' => 'オリーブ系','color_code' => '#808000'],
          ['color_list' => 'ブルー系','color_code' => '#0000FF'],
          ['color_list' => 'ネイビー系','color_code' => '#000080'],
          ['color_list' => 'ターコイズ系','color_code' => '#40E0D0'],
          ['color_list' => 'ラベンダー系','color_code' => '#E6E6FA'],
          ['color_list' => 'パープル系','color_code' => '#800080'],
          ['color_list' => 'バイオレット系','color_code' => '#EE82EE'],
          ['color_list' => 'レッド系','color_code' => '#FF0000'],
          ['color_list' => 'ピンク系','color_code' => '#FFC0CB'],
          ['color_list' => 'オレンジ系','color_code' => '#FFA500'],
          ['color_list' => 'イエロー系','color_code' => '#FFFF00'],
          ['color_list' => 'ゴールド系','color_code' => '#FFD700'],
          ['color_list' => 'シルバー系','color_code' => '#C0C0C0'],
      ]);
    }
}
