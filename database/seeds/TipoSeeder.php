<?php

use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo')->truncate();
        
        //Tipo de Dimensiones y Metricas----------------------------------------------------------

        DB::table('tipo')->insert([
            'id' => '1',
            'nombre' => 'User',
        ]);

        DB::table('tipo')->insert([
            'id' => '2',
            'nombre' => 'Session',
        ]);

        DB::table('tipo')->insert([
            'id' => '3',
            'nombre' => 'Traffic Sources',
        ]);

        DB::table('tipo')->insert([
            'id' => '4',
            'nombre' => 'Adwords',
        ]);

        DB::table('tipo')->insert([
            'id' => '5',
            'nombre' => 'Goal Conversions',
        ]);

        DB::table('tipo')->insert([
            'id' => '6',
            'nombre' => 'Platform or Device',
        ]);

        DB::table('tipo')->insert([
            'id' => '7',
            'nombre' => 'Geo Network',
        ]);

        DB::table('tipo')->insert([
            'id' => '8',
            'nombre' => 'System',
        ]);

        DB::table('tipo')->insert([
            'id' => '9',
            'nombre' => 'Social Activities',
        ]);

        DB::table('tipo')->insert([
            'id' => '10',
            'nombre' => 'Page Tracking',
        ]);

        DB::table('tipo')->insert([
            'id' => '11',
            'nombre' => 'Content Grouping',
        ]);

        DB::table('tipo')->insert([
            'id' => '12',
            'nombre' => 'Internal Search',
        ]);

        DB::table('tipo')->insert([
            'id' => '13',
            'nombre' => 'Site Speed',
        ]);

        DB::table('tipo')->insert([
            'id' => '14',
            'nombre' => 'App Tracking',
        ]);

        DB::table('tipo')->insert([
            'id' => '15',
            'nombre' => 'Event Tracking',
        ]);

        DB::table('tipo')->insert([
            'id' => '16',
            'nombre' => 'Ecommerce',
        ]);

        DB::table('tipo')->insert([
            'id' => '17',
            'nombre' => 'Social Interactions',
        ]);

        DB::table('tipo')->insert([
            'id' => '18',
            'nombre' => 'User Timings',
        ]);

        DB::table('tipo')->insert([
            'id' => '19',
            'nombre' => 'Exceptions',
        ]);

        DB::table('tipo')->insert([
            'id' => '20',
            'nombre' => 'Content Experiments',
        ]);

        DB::table('tipo')->insert([
            'id' => '21',
            'nombre' => 'Custom Variables or Columns',
        ]);

        DB::table('tipo')->insert([
            'id' => '22',
            'nombre' => 'Time',
        ]);

        DB::table('tipo')->insert([
            'id' => '23',
            'nombre' => 'DoubleClick Campaign Manager',
        ]);

        DB::table('tipo')->insert([
            'id' => '24',
            'nombre' => 'Audience',
        ]);

        DB::table('tipo')->insert([
            'id' => '25',
            'nombre' => 'Ad Sense',
        ]);

        DB::table('tipo')->insert([
            'id' => '26',
            'nombre' => 'Ad Exchange',
        ]);

        DB::table('tipo')->insert([
            'id' => '27',
            'nombre' => 'DoubleClick for Publishers',
        ]);

        DB::table('tipo')->insert([
            'id' => '28',
            'nombre' => 'DoubleClick for Publishers Backfill',
        ]);

        DB::table('tipo')->insert([
            'id' => '29',
            'nombre' => 'Lifetime Value and Cohorts',
        ]);

        DB::table('tipo')->insert([
            'id' => '30',
            'nombre' => 'Channel Grouping',
        ]);

        DB::table('tipo')->insert([
            'id' => '31',
            'nombre' => 'Related Products',
        ]);

        DB::table('tipo')->insert([
            'id' => '32',
            'nombre' => 'Personalizados',
        ]);
    }
}
