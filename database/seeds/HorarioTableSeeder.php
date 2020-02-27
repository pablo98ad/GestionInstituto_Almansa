<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class HorarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $horas =  array('1','2','3','4','5','6','7','R');
        $dias = array('L','M','X','J','V');

        for($i=1; $i<=10;$i++){
            DB::table('horario')->insert([
                'profesor_id' => $i,
                'grupo_id' => $i,
                'aula_id' => $i,
                'dia' => $dias[array_rand($dias)],
                'hora' => $horas[array_rand($horas)],
                'observaciones' => str_random(12),
                'esProfesor' => array_rand(array(True, False)),
                'materia_id' => $i,             
            ]);
        }
    }
}
