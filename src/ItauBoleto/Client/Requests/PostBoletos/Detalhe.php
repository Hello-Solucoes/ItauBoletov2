<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Detalhe implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $descricao;
    public $conteudo_anterior;
    public $conteudo_atual;

}