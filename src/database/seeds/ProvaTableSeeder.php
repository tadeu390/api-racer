<?php

use App\Models\Prova;
use Illuminate\Database\Seeder;

class ProvaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Prova::class, 50)->create();
    }
}
