<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class Campos implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $campo;

    /**
     * @var
     */
    public $mensagem;

    /**
     * @var
     */
    public $valor;

}