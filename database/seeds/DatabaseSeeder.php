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
        // Disable Foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $this->call(TipoSeeder::class);
        $this->call(DimensionSeeder::class);
        $this->call(MetricaSeeder::class);
        $this->call(SegmentoSeeder::class);

        // Enable Foreign Keys Again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
