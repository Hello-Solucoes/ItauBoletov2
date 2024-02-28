<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

use Alexandreo\ItauBoleto\Client\ItauRequest;
use Alexandreo\ItauBoleto\Client\Requests\Request;

/**
 *
 */
class PostBoletosRequest implements ItauRequest
{

    use Request;

    /**
     * @var string
     * UUID que identifica o boleto
     */
    public $id_boleto;
    /**
     * @var string
     * Define a etapa de negocio executada. Campo usado para a etapa de emissão de boleto.
     */
    public $etapa_processo_boleto;
    /**
     * @var string
     * Código do canal de operação
     */
    public $codigo_canal_operacao = 'API';
    /**
     * @var
     */

    protected $beneficiario;
    /**
     * @var
     */
    protected $dado_boleto;
    /**
     * @var
     */
    protected $acoes_permitidas;

    /**
     * @param mixed $beneficiario
     */
    public function setBeneficiario(Beneficiario $beneficiario)
    {
        $this->beneficiario = $beneficiario;
    }

    /**
     * @param mixed $dado_boleto
     */
    public function setDadoBoleto($dado_boleto)
    {
        $this->dado_boleto = $dado_boleto;
    }

    /**
     * @param mixed $acoes_permitidas
     */
    public function setAcoesPermitidas(AcoesPermitidas $acoes_permitidas)
    {
        $this->acoes_permitidas = $acoes_permitidas;
    }

}