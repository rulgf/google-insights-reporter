<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Metrica;
use App\Dimension;
use App\Cuentas;

class metricaDimesnionTest extends TestCase
{
    /**
     * @group getMetricas
     *
     * @return void
     */
    public function testGetMetricas()
    {
        $this->withoutMiddleware();

        $response = json_decode($this->call('GET', 'metricas')->getContent(), true);
        $cuentas = Metrica::get();

        $this->assertEquals(count($cuentas), count($response));
    }

    /**
     * @group getDimensiones
     *
     * @return void
     */
    public function testGetDimensiones()
    {
        $this->withoutMiddleware();

        $response = json_decode($this->call('GET', 'dimensiones')->getContent(), true);
        $cuentas = Dimension::get();

        $this->assertEquals(count($cuentas), count($response));
    }

    /**
     * @group createDimensionMetrica
     * @return void
     */
    public function testCreateMetricaExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $metricas_before = Metrica::get();

        $response = $this->post('metricas', [
            'nombre' => 'Metrica Prueba',
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $metricas_after= Metrica::get();
        $this->assertGreaterThan(count($metricas_before), count($metricas_after));

        $metrica = Metrica::where('nombre', 'Metrica Prueba')->first();
        $metrica->delete();

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }


    /**
     * @group createDimensionMetrica
     * @return void
     */
    public function testCreateDimensionExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $dimensiones_before = Dimension::get();

        $response = $this->post('dimensiones', [
            'nombre' => 'Dimension Prueba',
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $dimensiones_after= Dimension::get();
        $this->assertGreaterThan(count($dimensiones_before), count($dimensiones_after));

        $dimension = Dimension::where('nombre', 'Dimension Prueba')->first();
        $dimension->delete();

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group createDimensionMetrica
     * @return void
     */
    public function testCreateMetricaFalla()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $metricas_before = Metrica::get();

        $response = $this->post('metricas', [
            'nombre' => null,
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $metricas_after= Metrica::get();
        $this->assertEquals(count($metricas_before), count($metricas_after));

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }


    /**
     * @group createDimensionMetrica
     * @return void
     */
    public function testCreateDimensionFalla()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $dimensiones_before = Dimension::get();

        $response = $this->post('dimensiones', [
            'nombre' => null,
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $dimensiones_after= Dimension::get();
        $this->assertEquals(count($dimensiones_before), count($dimensiones_after));

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group editDimensionMetrica
     * @return void
     */
    public function testEditMetricaExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $response = $this->post('metricas', [
            'nombre' => 'Metrica Prueba',
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $metrica_before = Metrica::where('nombre', 'Metrica Prueba')->first();

        $edit = $this->put('metricas/'.$metrica_before->id, [
            'nombre' => 'Metrica Prueba',
            'clave' => '12345',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $metrica_after = Metrica::where('nombre', 'Metrica Prueba')->first();
        $this->assertNotEquals($metrica_before->clave, $metrica_after->clave);

        $metrica_after->delete();

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group editDimensionMetrica
     * @return void
     */
    public function testEditDimensionExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $response = $this->post('dimensiones', [
            'nombre' => 'Dimension Prueba',
            'clave' => '1234',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $dimension_before = Dimension::where('nombre', 'Dimension Prueba')->first();

        $edit = $this->put('dimensiones/'.$dimension_before->id, [
            'nombre' => 'Dimension Prueba',
            'clave' => '12345',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $dimension_after = Dimension::where('nombre', 'Dimension Prueba')->first();
        $this->assertNotEquals($dimension_before->clave, $dimension_after->clave);

        $dimension_after->delete();

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group deleteDimensionMetricas
     *
     * @return void
     */
    public function testDeleteMetricasExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $response = $this->post('metricas', [
            'nombre' => 'Metrica Prueba',
            'clave' => '123',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $metricas_before = Metrica::get();

        $metrica = Metrica::where('nombre', 'Metrica Prueba')->first();

        $response = $this->delete('metricas/'.$metrica->id, [
            '_token' => csrf_token()]);

        $metricas_after= Metrica::get();
        $this->assertGreaterThan(count($metricas_after), count($metricas_before));

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group deleteDimensionMetricas
     *
     * @return void
     */
    public function testDeleteDimensionExitoso()
    {
        $this->withoutMiddleware();

        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $response = $this->post('dimensiones', [
            'nombre' => 'Dimension Prueba',
            'clave' => '123',
            'tipo_id' => '32',
            'cuenta_id' => 'ga:123',
            '_token' => csrf_token()]);

        $dimensiones_before = Dimension::get();

        $dimension = Dimension::where('nombre', 'Dimension Prueba')->first();

        $response = $this->delete('dimensiones/'.$dimension->id, [
            '_token' => csrf_token()]);

        $dimensiones_after= Dimension::get();
        $this->assertGreaterThan(count($dimensiones_after), count($dimensiones_before));

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }


}
