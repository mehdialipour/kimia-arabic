<?php

use Illuminate\Database\Seeder;
use App\Models\Insurance;

class InsuranceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insurance::create([
        	'name' => 'آزاد'
        ]);

        Insurance::create([
        	'name' => 'تامین اجتماعی'
        ]);
    }
}
