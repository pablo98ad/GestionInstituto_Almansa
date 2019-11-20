<?php

use Illuminate\Database\Seeder;

class AulaTableSeeder extends Seeder
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
            DB::table('aula')->insert([
                'nombre' => str_random(6),
                'descripcion' => str_random(12),
                'numero' => rand(0,50),
                'reservable' => array_rand(array(True, False)),                
            ]);
        }
    }
}
