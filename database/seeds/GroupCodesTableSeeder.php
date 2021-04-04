<?php

use Illuminate\Database\Seeder;

class GroupCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('group_codes')->insert([
        'company_id' => '2',
        'group_code' => 'EHR66038',
      ]);
      DB::table('group_codes')->insert([
        'company_id' => '2',
        'group_code' => 'EHS67025',
      ]);
      DB::table('group_codes')->insert([
        'company_id' => '2',
        'group_code' => 'RTG30028',
      ]);
      DB::table('group_codes')->insert([
        'company_id' => '2',
        'group_code' => 'DPG20038',
      ]);
      DB::table('group_codes')->insert([
        'company_id' => '2',
        'group_code' => 'DCH30019',
      ]);
      factory(App\Models\GroupCode::class, 1000)->create();
    }
}
