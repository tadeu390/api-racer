<?php

namespace App\Models\Traits\Corredor;

/**
 * Class CorredorMutator
 *
 * @package App\Models\Traits\Corredor
 */
trait CorredorMutator
{
    /**
     * Define o formato da data de nascimento.
     *
     * @param string  $value
     *
     * @return void
     */
    public function setDataNascimentoAttribute($value)
    {
        if (!$value) {
            return false;
        }

        try {
            $this->attributes['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value);
        } catch(\Exception $e) {
            $this->attributes['data_nascimento'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
        }
    }
}
