<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class AcoesPermitidas implements \Alexandreo\ItauBoleto\Client\ItauRequest
{
    public $emitir_segunda_via;
    public $comandar_instrucao_alterar_dados_cobranca;
}