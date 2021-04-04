<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'メンテナンスユーザー',
        'email' => 'master@storemap.jp',
        'password' => Hash::make('aaaaaaaa'),
        'role' => 'admin',
        'company_id' => '1',
        'remember_token'    => Str::random(10),
      ]);
      //   DB::table('users')->insert([
      //   'name' => '販売管理者　松田',
      //   'email' => 'seller@seller',
      //   'password' => Hash::make('aaaaaaaa'),
      //   'role' => 'seller',
      //   'company_id' => '1',
      //   'remember_token'    => Str::random(10),
      // ]);
      //   DB::table('users')->insert([
      //   'name' => 'スタッフ　松田',
      //   'email' => 'staff@staff',
      //   'password' => Hash::make('aaaaaaaa'),
      //   'role' => 'staff',
      //   'company_id' => '1',
      //   'remember_token'    => Str::random(10),
      // ]);
      DB::table('users')->insert([
        'name'            => '松田　智哉',
        'email'           => 'webmatsu@tophouse.jp',
        'password'        => Hash::make('aaaaaaaa'),
        'role'            => 'seller',
        'company_id'      => '2',
        'remember_token'  => Str::random(10),
      ]);
      //   factory(App\Models\User::class, 500)->create();
    }
}
