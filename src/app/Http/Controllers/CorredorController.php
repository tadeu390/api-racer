<?php

namespace App\Http\Controllers;

use App\Services\CorredorService;
use App\Http\Requests\CorredorRequest;

class CorredorController extends Controller
{
    /**
     * @var CorredorService
     */
    protected $corredor;

    /**
     * Injeta as dependências necessárias.
     */
    public function __construct(CorredorService $corredor)
    {
        $this->corredor = $corredor;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\CorredorRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorredorRequest $request)
    {
        $result = $this->corredor->store($request->all());
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }
}
