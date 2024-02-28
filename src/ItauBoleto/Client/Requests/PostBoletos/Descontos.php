<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class Descontos implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $percentual_desconto;

    /**
     * @var
     */
    public $valor_desconto;

    /**
     * @var
     */
    public $quantidade_dias_desconto;

}