<?php

namespace App\Repositories\Contracts;

interface ResultadoRepositoryInterface
{
    public function listaPorIdade($tipo_prova);
    public function listaGeral();
}
