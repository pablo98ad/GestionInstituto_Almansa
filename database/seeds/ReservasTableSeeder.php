<?php

use Illuminate\Database\Seeder;

class ReservasTableSeeder extends Seeder
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
        for($i=1; $i<=10;$i++){
            DB::table('reservas')->insert([
                'profesor_id' => $i,
                'aula_id' => $i,
                'fecha' => new DateTime('NOW'),
                'hora' => $horas[array_rand($horas)],
                'observaciones' => str_random(50),
                
                
            ]);
        }
    }
}
