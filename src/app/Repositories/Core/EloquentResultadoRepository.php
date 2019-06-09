<?php

namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ResultadoRepositoryInterface;
use App\Models\Resultado;

/**
 * Camada de repositório. Esta classe implementa os métodos de uma interface.
 */
class EloquentResultadoRepository extends BaseEloquentRepository implements ResultadoRepositoryInterface
{
    /**
     * Retorna o modelo a que esta classe se refere.
     */
    public function entity()
    {
        return Resultado::class;
    }

    /**
     * Realiza a busca no banco de dados de todos os resultados para uma determinada prova.
     *
     * @param string $tipo_prova
     *
     * @return object
     */
    public function listaPorIdade($tipo_prova)
    {
        $result = \DB::select( \DB::raw("
        SELECT p.id AS prova_id, p.tipo_prova, c.id AS corredor_id, (DATEDIFF(now(), c.data_nascimento) / 365) AS idade,
        c.nome AS nome_corredor, TIME_TO_SEC(TIMEDIFF(r.horario_fim, r.horario_inicio)) AS tempo

        FROM resultados r
        INNER JOIN corredores c ON c.id = r.corredor_id
        INNER JOIN provas p ON p.id = r.prova_id
        WHERE p.tipo_prova = :tipo_prova
        ORDER BY c.data_nascimento DESC
        "), array(
            'tipo_prova' => $tipo_prova
        ));

        return $this->posicoesPorIdade($result);
    }

    /**
     * Realiza a busca de todas as provas no banco de dados.
     *
     * @return object
     */
    public function listaGeral()
    {
        $result = \DB::select( \DB::raw("
            SELECT p.id AS prova_id, p.tipo_prova, c.id AS corredor_id, (DATEDIFF(now(), c.data_nascimento) / 365) AS idade,
            c.nome AS nome_corredor, TIME_TO_SEC(TIMEDIFF(r.horario_fim, r.horario_inicio)) AS tempo

            FROM resultados r
            INNER JOIN corredores c ON c.id = r.corredor_id
            INNER JOIN provas p ON p.id = r.prova_id
            ORDER BY p.tipo_prova DESC
        "));

        return $this->posicoesPorProva($result);
    }

    /**
     * Estabelece a posição de cada corredor em cada faixa de idade.
     *
     * @return object
     */
    public function posicoesPorIdade($result)
    {
        $idadesMaxima = [25, 35, 45, 55, 500];
        $i = 0;
        $inicio = 0;
        $tempo = [];
        for ($a = 0; $a <= count($result); $a++) {
            if ($a < count($result) && $result[$a]->idade < $idadesMaxima[$i]) {
                array_push($tempo, $result[$a]->tempo);
            } else {
                asort($tempo);
                $tempo = array_values($tempo);
                foreach ($tempo as $key => $value) {
                    for ($k = $inicio; $k < $a; $k++) {
                        if (isset($result[$k]->tempo) && $result[$k]->tempo == $value) {
                            $result[$k]->posicao = ($key + 1)."º lugar";
                            unset($result[$k]->tempo);
                            $result[$k]->idade = (int)$result[$k]->idade;
                        }
                    }
                }
                $inicio = $a;
                $tempo = [];
                if ($a < count($result)) {
                    array_push($tempo, $result[$a]->tempo);
                }
                $i++;
            }
        }

        return $result;
    }

    /**
     * Estabelece a posição de cada corredor por tipo de pŕova.
     *
     * @return object
     */
    public function posicoesPorProva($result)
    {
        $tipo_provas = \DB::select( \DB::raw("
            SELECT tipo_prova FROM provas
            ORDER BY tipo_prova
        "));

        $i = 0;
        $inicio = 0;
        $tempo = [];
        for ($a = 0; $a <= count($result); $a++) {
            if ($a < count($result) && $result[$a]->tipo_prova == $tipo_provas[$i]->tipo_prova) {
                array_push($tempo, $result[$a]->tempo);
            } else {
                asort($tempo);
                $tempo = array_values($tempo);
                foreach ($tempo as $key => $value) {
                    for ($k = $inicio; $k < $a; $k++) {
                        if (isset($result[$k]->tempo) && $result[$k]->tempo == $value) {
                            $result[$k]->posicao = ($key + 1)."º lugar";
                            unset($result[$k]->tempo);
                            $result[$k]->idade = (int)$result[$k]->idade;
                        }
                    }
                }
                $inicio = $a;
                $tempo = [];
                if ($a < count($result)) {
                    array_push($tempo, $result[$a]->tempo);
                }
                $i++;
            }
        }

        return $result;
    }
}
