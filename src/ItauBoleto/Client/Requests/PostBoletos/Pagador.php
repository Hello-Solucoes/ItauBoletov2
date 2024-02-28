<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Pagador implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var string
     * identificação do pagador
     */
    public $id_pagador;
    /**
     * @var
     */
    public $pessoa;
    /**
     * @var
     */
    public $endereco;
    /**
     * @var string
     * Endereço de email
     */
    public $texto_endereco_email;

    /**
     * @var string
     * Número do DDD
     */
    public $numero_ddd;
    /**
     * @var string
     * Número do telefone
     */
    public $numero_telefone;
    /**
     * @var string
     * Data e hora de inclusão ou alteração dos dados do Pagador
     */
    public $data_hora_inclusao_alteracao;

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