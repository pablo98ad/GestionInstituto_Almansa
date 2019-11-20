<?php

use Illuminate\Database\Seeder;

class ProfesorTableSeeder extends Seeder
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
            DB::table('profesor')->insert([
                'nombre' => str_random(10),
                'apellidos' => str_random(5).' '.str_random(12),
                'departamento' => str_random(5),
                'especialidad' => str_random(6),
                'cargo' => str_random(5),
                'observaciones' => str_random(50),
                'codigo' => 'PRO'.$i,
                
            ]);
        }
    }
}
