<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class Multa implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $codigo_tipo_multa;
    /**
     * @var
     */
    public $quantidade_dias_multa;
    /**
     * @var
     */
    public $valor_multa;
    /**
     * @var
     */
    public $percentual_multa;

}