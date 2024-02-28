<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class SacadorAvalista implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $pessoa;
    public $endereco;
    public $exclusao_sacador_avalista;

    /**
     * @param mixed $pessoa
     */
    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

}