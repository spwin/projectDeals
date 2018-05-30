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
        factory(App\User::class)->create([
            'first_name' => 'Stanislav',
            'last_name' => 'Markevic',
            'email' => 'admin@friyay.london',
            'password' => bcrypt('friyay123'),
            'role' => 'admin',
        ]);

        factory(App\User::class)->create([
            'email' => 'manager@friyay.london',
            'password' => bcrypt('friyay123'),
            'role' => 'manager',
        ]);

        factory(App\User::class, 100)->create();
        factory(App\User::class, 50)->create(['role' => 'manager']);
    }
}