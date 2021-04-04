<?php

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
          [
            'title' => 'TEST',
            'start' => '2020-07-17 21:30:00',
            'end' => '2020-07-18 21:30:00',
            'color' => '#007bff',
            'description' => 'TESTですよ',
            'store_id' => '1',
          ],
          [
            'title' => 'TEL client',
            'start' => '2020-07-20',
            'end' => '2020-07-20',
            'color' => '#ffc107',
            'description' => 'クライアントに電話',
            'store_id' => '1',
          ],
        ]);
    }
}
