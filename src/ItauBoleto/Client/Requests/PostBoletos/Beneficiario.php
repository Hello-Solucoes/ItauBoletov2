<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class Beneficiario implements \Alexandreo\ItauBoleto\Client\ItauRequest
{
    /**
     * @var
     */
    public $id_beneficiario;

    /**
     * @var
     */
    public $nome_cobranca;

    /**
     * @var
     */
    public $tipo_pessoa;

    /**
     * @var
     */
    public $endereco;

    /**
     * @param mixed $tipo_pessoa
     */
    public function setTipoPessoa(TipoPessoa $tipo_pessoa)
    {
        $this->tipo_pessoa = $tipo_pessoa;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

}