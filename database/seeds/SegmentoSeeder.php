<?php

use Illuminate\Database\Seeder;

class SegmentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('segmentos')->truncate();

        DB::table('segmentos')->insert([
            'nombre' => 'Todos los Usuarios',
            'clave' => 'gaid::-1'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Nuevos Usuarios',
            'clave' => 'gaid::-2'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Usuarios Recurrentes',
            'clave' => 'gaid::-3'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico Pagado',
            'clave' => 'gaid::-4'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico Organico',
            'clave' => 'gaid::-5'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de Búsqueda',
            'clave' => 'gaid::-6'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico Directo',
            'clave' => 'gaid::-7'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de Referencia',
            'clave' => 'gaid::-8'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Sesiones con Conversiones',
            'clave' => 'gaid::-9'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Sesiones con Transacciones',
            'clave' => 'gaid::-10'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico Móvil y de Tablet',
            'clave' => 'gaid::-11'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Sesiones sin Rebote',
            'clave' => 'gaid::-12'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de Tablet',
            'clave' => 'gaid::-13'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico Móvil',
            'clave' => 'gaid::-14'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de Tablets y Escritorio',
            'clave' => 'gaid::-15'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de Android',
            'clave' => 'gaid::-16'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Tráfico de iOS',
            'clave' => 'gaid::-17'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Otro Tráfico (Ni iOS o Android)',
            'clave' => 'gaid::-18'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Sesiones Rebotadas',
            'clave' => 'gaid::-19'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Usuarios de sesión única',
            'clave' => 'gaid::-100'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Usuarios de Múltiples Sesiones',
            'clave' => 'gaid::-101'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Convertidores',
            'clave' => 'gaid::-102'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'No-Convertidores',
            'clave' => 'gaid::-103'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Hicieron una Compra',
            'clave' => 'gaid::-104'
        ]);

        DB::table('segmentos')->insert([
            'nombre' => 'Realizaron Búsqueda del Sitio',
            'clave' => 'gaid::-105'
        ]);
    }
}
