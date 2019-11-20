<?php

use Illuminate\Database\Seeder;

class MateriaTableSeeder extends Seeder
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
            DB::table('materia')->insert([
                'nombre' => str_random(6),
                'departamento' => str_random(4),
                'observaciones' => str_random(40),
                 ]);
        }
    }
}
