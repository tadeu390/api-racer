<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class CorredorApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function incluir_corredor()
    {
        $data = [
            'nome' => 'Tadeu',
            'cpf'=> '123',
            'data_nascimento' => '17/05/1995',
        ];

        $request = $this->post('/api/corredores/', $data);

        $request->assertStatus(Response::HTTP_CREATED);
    }
}
