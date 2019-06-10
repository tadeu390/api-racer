<?php

namespace App\Models\Traits\Prova;

/**
 * Class ProvaMutator
 *
 * @package App\Models\Traits\Prova
 */
trait ProvaMutator
{
    /**
     * Define o formato da data da prova.
     *
     * @param string  $value
     *
     * @return void
     */
    public function setDataAttribute($value)
    {
        if (!$value) {
            return false;
        }

        try {
            $this->attributes['data'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value);
        } catch(\Exception $e) {
            $this->attributes['data'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
        }
    }
}
