<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompaniesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(GroupCodesTableSeeder::class);
        // $this->call(ItemsTableSeeder::class);
        // $this->call(ItemStoreTableSeeder::class);
        $this->call(StoreUserTableSeeder::class);
        // $this->call(EventTableSeeder::class);
        $this->call(FastEventTableSeeder::class);
        // $this->call(TopicTableSeeder::class);
    }
}
