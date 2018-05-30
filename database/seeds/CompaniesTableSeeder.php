<?php

use App\User;
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
        $managers = User::where('role', '=', 'manager')->get();
        foreach($managers as $manager){
            factory(App\Company::class)->create(['user_id' => $manager->id]);
        }
    }
}