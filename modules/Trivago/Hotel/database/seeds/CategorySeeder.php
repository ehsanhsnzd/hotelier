<?php
namespace Hotel\database\seeds;
use Hotel\app\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::firstOrCreate([
            'name' => 'hotel',
        ]);
        Category::firstOrCreate([
            'name' => 'alternative',
        ]);
        Category::firstOrCreate([
            'name' => 'hostel',
        ]);
        Category::firstOrCreate([
            'name' => 'lodge',
        ]);
        Category::firstOrCreate([
            'name' => 'resort',
        ]);
        Category::firstOrCreate([
            'name' => 'guest-house',
        ]);


    }
}
