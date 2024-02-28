<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Negativacao implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var number
     * Código que indica qual o tipo de acao de negativação" 1 - Negativar 2 - Não Negativar 3 - Cancelar Negativação
     */
    public $codigo_tipo_negativacao;

    /**
     * @var number
     * Quantidade de dias após o vencimento para negativar o título
     */
    public $quantidade_dias_negativacao;

}