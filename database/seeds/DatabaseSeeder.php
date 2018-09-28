<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(DealsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(RotationTableSeeder::class);
        $this->call(ListingsTableSeeder::class);
        $this->call(ListingCategoryTableSeeder::class);
        $this->call(DealReviewsTableSeeder::class);
        $this->call(ParticipationTableSeeder::class);
    }
}
