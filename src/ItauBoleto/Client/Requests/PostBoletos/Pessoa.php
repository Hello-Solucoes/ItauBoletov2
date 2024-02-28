<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Pessoa implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $nome_pessoa;
    /**
     * @var
     */
    public $nome_fantasia;
    /**
     * @var
     */
    public $tipo_pessoa;

    /**
     * @param mixed $tipo_pessoa
     */
    public function setTipoPessoa(TipoPessoa $tipo_pessoa)
    {
        $this->tipo_pessoa = $tipo_pessoa;
    }


}