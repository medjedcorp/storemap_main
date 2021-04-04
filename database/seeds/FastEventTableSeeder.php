<?php

use Illuminate\Database\Seeder;

class FastEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('fast_events')->insert([
        [
          'title' => 'Open',
          'start' => '10:00:00',
          'end' => '19:00:00',
          'color' => '#007bff',
          'store_id' => '1'
        ],
        [
          'title' => 'Reserved',
          'start' => '10:00:00',
          'end' => '18:00:00',
          'color' => '#ffc107',
          'store_id' => '1'
        ],
        [
          'title' => 'Event',
          'start' => '13:00:00',
          'end' => '14:00:00',
          'color' => '#28a745',
          'store_id' => '1'
        ],
        [
          'title' => 'Closed',
          'start' => '00:00:00',
          'end' => '10:00:00',
          'color' => '#dc3545',
          'store_id' => '1'
        ],
        [
          'title' => 'Information',
          'start' => '00:00:00',
          'end' => '23:59:00',
          'color' => '#6c757d',
          'store_id' => '1'
        ],
      ]);
    }
}
