<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class Protesto implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var number
     * "Código que indica qual o tipo de acao de protesto" 1 - Protestar 2 - Não Protestar 3 - Sustar Protesto em andamento
     */
    public $codigo_tipo_protesto = 2;
    /**
     * @var number
     * Quantidade de dias após o vencimento para protestar o título
     */
    public $quantidade_dias_protesto;

    /**
     * @var boolean
     * Modalidade especial de protesto, na qual o credor ganha o direito de requerer judicialmente a falência de empresa devedora
     */
    public $protesto_falimentar;

}