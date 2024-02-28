<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Endereco implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var string
     * nome do logradouro, numero, complemento
     */
    public $nome_logradouro;

    /**
     * @var string
     * nome do bairro
     */
    public $nome_bairro;

    /**
     * @var string
     * nome da cidade
     */
    public $nome_cidade;

    /**
     * @var string
     * sigla da UF
     */
    public $sigla_UF;

    /**
     * @var string
     * CEP
     */
    public $numero_CEP;


}