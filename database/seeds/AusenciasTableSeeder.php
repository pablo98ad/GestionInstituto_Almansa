<?php

use Illuminate\Database\Seeder;

class AusenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $horas= array('1','2','3','4','5','6','7','R');

        for($i=1; $i<=10;$i++){
            DB::table('ausencias')->insert([
                'fecha' => new DateTime(),
                'hora' => $horas[array_rand($horas)],
                'observaciones1' => str_random(12),
                'observaciones2' => str_random(12),
                'profesor_id' => $i,
                'profesor_sustituye_id' => $i,
                ]);
        }
    }
}
