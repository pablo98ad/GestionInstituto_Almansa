<?php

use Illuminate\Database\Seeder;

class AlumnoTableSeeder extends Seeder
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
            DB::table('alumno')->insert([
                'nombre' => str_random(12),
                'apellidos' => str_random(5).' '.str_random(12),
                'grupo_id' => $i,
                'nombrePadre' => str_random(6),
                'nombreMadre' => str_random(6),
                'telefono1' => rand(600000000,999999999),
                'telefono2' => rand(600000000,999999999),
                'fechaNacimiento' => new DateTime('NOW'),
                'observaciones' => str_random(12),
                            
            ]);
        }
    }
}
