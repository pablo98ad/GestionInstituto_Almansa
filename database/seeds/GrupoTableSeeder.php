<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GrupoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10;$i++){
            DB::table('grupo')->insert([
                'nombre' => str_random(6),
                'descripcion' => str_random(12),
                'nombreTutor' => str_random(5),
                'curso' => str_random(3),                
            ]);
        }
    }
}