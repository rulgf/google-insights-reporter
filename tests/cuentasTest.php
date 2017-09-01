<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cuentas;

class cuentasTest extends TestCase
{

    /**
     * @group getCuentas
     *
     * @return void
     */
    public function testGetCuentas()
    {
        $this->withoutMiddleware();

        $response = json_decode($this->call('GET', 'cuentas')->getContent(), true);
        $cuentas = Cuentas::get();

        $this->assertEquals(count($cuentas), count($response));
    }

    /**
     * @group createCuentas
     *
     * @return void
     */
    public function testCreateCuentasExitoso()
    {
        $this->withoutMiddleware();

        $cuentas_before = Cuentas::get();
        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'siteId' => '123',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $cuentas_after= Cuentas::get();
        $this->assertGreaterThan(count($cuentas_before), count($cuentas_after));

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group createCuentas
     *
     * @return void
     */
    public function testCreateCuentasFalla()
    {
        $this->withoutMiddleware();

        $cuentas_before = Cuentas::get();
        $response = $this->post('cuentas', [
            'nombre' => 'Nombre Prueba',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $cuentas_after= Cuentas::get();
        $this->assertEquals(count($cuentas_before), count($cuentas_after));
    }

    /**
     * @group editCuentas
     *
     * @return void
     */
    public function testEditCuentaExitoso()
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

        $cuenta_before = Cuentas::where('nombre', 'Nombre Prueba')->first();

        $response = $this->put('cuentas/'. $cuenta_before->id, [
            'nombre' => 'Nombre Prueba',
            'siteId' => '1234',
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $cuenta_after= Cuentas::where('nombre', 'Nombre Prueba')->first();
        $this->assertNotEquals($cuenta_before->siteId, $cuenta_after->siteId);

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group editCuentas
     *
     * @return void
     */
    public function testEditCuentaFallido()
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

        $cuenta_before = Cuentas::where('nombre', 'Nombre Prueba')->first();

        $response = $this->put('cuentas/'. $cuenta_before->id, [
            'nombre' => 'Nombre Prueba',
            'siteId' => null,
            'nombre_cliente' => 'Prueba',
            'email_cliente' => 'prueba@prueba.com',
            'active' => 0,
            'semaforo_state' => 0,
            'campaign_id' => 123,
            '_token' => csrf_token()]);

        $cuenta_after= Cuentas::where('nombre', 'Nombre Prueba')->first();
        $this->assertEquals($cuenta_before->siteId, $cuenta_after->siteId);

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();
        $cuenta->delete();
    }

    /**
     * @group deleteCuentas
     *
     * @return void
     */
    public function testDeleteCuentasExitoso()
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
        $cuentas_before = Cuentas::get();

        $cuenta = Cuentas::where('nombre', 'Nombre Prueba')->first();

        $response = $this->delete('cuentas/'.$cuenta->id, [
            '_token' => csrf_token()]);

        $cuentas_after= Cuentas::get();
        $this->assertGreaterThan(count($cuentas_after), count($cuentas_before));
    }

}
