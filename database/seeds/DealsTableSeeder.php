<?php

use App\File;
use Illuminate\Database\Seeder;

class DealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Deal::class, 200)->create()->each(function($u) {
            for($i = 0; $i < rand(0,4); $i++) {
                if ($image = randomImg()) {
                    $image_file = new File();
                    $image_file->saveFile('deal_gallery', $image);
                    $u->gallery()->attach($image_file, ['order' => $i]);
                }
            }
        });
    }
}