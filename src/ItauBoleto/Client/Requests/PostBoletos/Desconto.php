<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Desconto implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $codigo_tipo_desconto;
    public $descontos = [];
    public $codigo;
    public $mensagem;
    public $campos;

    /**
     * @param mixed $descontos
     */
    public function setDescontos(Descontos $descontos)
    {
        $this->descontos[] = $descontos;
    }

    /**
     * @param mixed $campos
     */
    public function setCampos(Campos $campos)
    {
        $this->campos[] = $campos;
    }

}