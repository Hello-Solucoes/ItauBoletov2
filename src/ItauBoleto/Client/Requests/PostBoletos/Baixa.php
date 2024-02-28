<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Baixa implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $codigo;
    public $mensagem;
    public $campos;
    public $codigo_motivo_boleto_cobranca_baixado;
    public $indicador_dia_util_baixa;
    public $data_hora_inclusao_alteracao_baixa;
    public $codigo_usuario_inclusao_alteracao;
    public $data_inclusao_alteracao_baixa;

    /**
     * @param mixed $campos
     */
    public function setCampos(Campos $campos)
    {
        $this->campos[] = $campos;
    }



}