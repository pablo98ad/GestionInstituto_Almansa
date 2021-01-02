<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            AnunciosTableSeeder::class,
            ProfesorTableSeeder::class,
            
            GrupoTableSeeder::class,
            AulaTableSeeder::class,

            AlumnoTableSeeder::class,
            MateriaTableSeeder::class,
            ReservasTableSeeder::class,
            
            
            HorarioTableSeeder::class,
            
            AusenciasTableSeeder::class,

            UsersTableSeeder::class
            
            
            
        ]);
    }
}
