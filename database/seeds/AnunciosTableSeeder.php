<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AnunciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1; $i<=10;$i++){
            DB::table('anuncios')->insert([
                'nombre' => str_random(6),
                'descripcion' => str_random(12),
                'inicio' => new DateTime('NOW'),
                'fin' => new DateTime('NOW'),
                'activo' => array_rand(array(True, False)),                
            ]);
        }
    }
}
