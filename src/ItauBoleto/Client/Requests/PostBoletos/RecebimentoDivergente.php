<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class RecebimentoDivergente implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $codigo_tipo_autorizacao;
    public $valor_minimo;
    public $percentual_minimo;
    public $valor_maximo;
    public $percentual_maximo;

}