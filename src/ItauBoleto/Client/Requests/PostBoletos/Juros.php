<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class Juros implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $codigo_tipo_juros;
    /**
     * @var
     */
    public $quantidade_dias_juros;
    /**
     * @var
     */
    public $valor_juros;
    /**
     * @var
     */
    public $percentual_juros;
    /**
     * @var
     */
    public $data_juros;

}