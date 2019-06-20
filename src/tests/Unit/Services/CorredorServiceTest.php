<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CorredorService;
use App\Repositories\Core\EloquentCorredorRepository;
use PHPUnit\Framework\Exception;

class CorredorServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function corredor_menor_de_idade()
    {
        $data = [
            'nome' => 'Tadeu',
            'cpf'=> '123',
            'data_nascimento' => '17/05/2010',
        ];

        $corredor = new CorredorService(new EloquentCorredorRepository);
        $resultado = $corredor->store($data);

        $this->assertEquals('O corredor deve ter pelo menos 18 anos.', $resultado['data']);
    }

    /**
     * @test
     */
    public function corredor_com_data_nascimento_no_padrao_invalido()
    {
        $data = [
            'nome' => 'Tadeu',
            'cpf'=> '123',
            'data_nascimento' => '17/05/2010fgh',
        ];

        $corredor = new CorredorService(new EloquentCorredorRepository);
        $resultado = $corredor->store($data);

        $this->assertEquals('O formato da data deve ser d/m/Y ou Y-m-d.', $resultado['data']);
    }
}
