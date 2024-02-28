<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Historico implements \Alexandreo\ItauBoleto\Client\ItauRequest
{
    public $data;
    public $operacao;
    public $conteudo_anterior;
    public $conteudo_atual;
    public $motivo;
    public $comandado_por;
    public $detalhe = [];

    /**
     * @param mixed $detalhe
     */
    public function setDetalhe(Detalhe $detalhe)
    {
        $this->detalhe[] = $detalhe;
    }


}