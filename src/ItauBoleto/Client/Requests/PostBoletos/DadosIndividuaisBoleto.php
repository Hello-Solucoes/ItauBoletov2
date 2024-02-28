<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class DadosIndividuaisBoleto implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $id_boleto_individual;
    /**
     * @var
     */
    public $status_boleto;
    /**
     * @var
     */
    public $situacao_geral_boleto;
    /**
     * @var
     */
    public $status_vencimento;
    /**
     * @var
     */
    public $mensagem_status_retorno;
    /**
     * @var
     */
    public $numero_nosso_numero;
    /**
     * @var
     */
    public $dac_titulo;
    /**
     * @var
     */
    public $data_vencimento;
    /**
     * @var float
     */
    public $valor_titulo = 0.00;
    /**
     * @var
     */
    public $texto_seu_numero;
    /**
     * @var
     */
    public $codigo_barras;
    /**
     * @var
     */
    public $numero_linha_digitavel;
    /**
     * @var
     */
    public $data_limite_pagamento;
    /**
     * @var array
     */
    public $mensagens_cobranca = [];
    /**
     * @var
     */
    public $texto_uso_beneficiario;


    /**
     * @param $mensagens_cobranca
     * @return void
     */
    public function setMensagensCobranca($mensagens_cobranca)
    {
        $this->mensagens_cobranca[] = $mensagens_cobranca;
    }

}