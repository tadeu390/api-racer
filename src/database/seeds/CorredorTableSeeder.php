<?php

use App\Models\Corredor;
use Illuminate\Database\Seeder;

class CorredorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Corredor::class, 50)->create();
    }
}
