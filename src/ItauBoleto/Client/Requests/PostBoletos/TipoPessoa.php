<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class TipoPessoa implements \Alexandreo\ItauBoleto\Client\ItauRequest
{
    /**
     * @var string
     * Tipo do pessoa
     */
    public $codigo_tipo_pessoa = 'F';

    /**
     * @var string
     * CPF - Obrigatório caso tipo_pessoa = F
     */
    public $numero_cadastro_pessoa_fisica;

    /**
     * @var string
     * CNPJ - Obrigatório caso tipo_pessoa = J
     */
    public $numero_cadastro_nacional_pessoa_juridica;

}