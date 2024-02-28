<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

/**
 *
 */
class DadoBoleto implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    /**
     * @var
     */
    public $descricao_instrumento_cobranca;
    /**
     * @var
     */
    public $tipo_boleto;
    /**
     * @var
     */
    public $forma_envio;
    /**
     * @var
     */
    public $quantidade_parcelas;
    /**
     * @var
     */
    public $protesto;
    /**
     * @var
     */
    public $negativacao;
    /**
     * @var array
     */
    public $instrucao_cobranca;
    /**
     * @var
     */
    public $pagador;
    /**
     * @var
     */
    public $sacador_avalista;
    /**
     * @var
     */
    public $codigo_carteira;
    /**
     * @var
     */
    public $codigo_tipo_vencimento;
    /**
     * @var
     */
    public $valor_total_titulo;
    /**
     * @var array
     */
    public $dados_individuais_boleto;
    /**
     * @var
     */
    public $codigo_especie;
    /**
     * @var
     */
    public $descricao_especie;
    /**
     * @var
     */
    public $codigo_aceite;
    /**
     * @var
     */
    public $data_emissao;
    /**
     * @var
     */
    public $pagamento_parcial;
    /**
     * @var
     */
    public $quantidade_maximo_parcial;
    /**
     * @var
     */
    public $valor_abatimento;
    /**
     * @var
     */
    public $juros;
    /**
     * @var
     */
    public $multa;
    /**
     * @var
     */
    public $desconto;
    /**
     * @var
     */
    public $mensagens_cobranca;
    /**
     * @var
     */
    public $recebimento_divergente;
    /**
     * @var
     */
    public $desconto_expresso = false;
    /**
     * @var
     */
    public $texto_uso_beneficiario;
    /**
     * @var
     */
    public $pagamentos_cobranca;
    /**
     * @var
     */
    public $historico;
    /**
     * @var
     */
    public $baixa;

    /**
     * @param mixed $protesto
     */
    public function setProtesto(Protesto $protesto)
    {
        $this->protesto = $protesto;
    }

    /**
     * @param mixed $negativacao
     */
    public function setNegativacao(Negativacao $negativacao)
    {
        $this->negativacao = $negativacao;
    }

    /**
     * @param mixed $instrucao_cobranca
     */
    public function setInstrucaoCobranca(InstrucaoCobranca $instrucao_cobranca)
    {
        $this->instrucao_cobranca[] = $instrucao_cobranca;
    }

    /**
     * @param mixed $pagador
     */
    public function setPagador(Pagador $pagador)
    {
        $this->pagador = $pagador;
    }

    /**
     * @param mixed $sacador_avalista
     */
    public function setSacadorAvalista(SacadorAvalista $sacador_avalista)
    {
        $this->sacador_avalista = $sacador_avalista;
    }

    /**
     * @param mixed $dados_individuais_boleto
     */
    public function setDadosIndividuaisBoleto(DadosIndividuaisBoleto $dados_individuais_boleto)
    {
        $this->dados_individuais_boleto[] = $dados_individuais_boleto;
    }

    /**
     * @param mixed $juros
     */
    public function setJuros(Juros $juros)
    {
        $this->juros = $juros;
    }

    /**
     * @param mixed $multa
     */
    public function setMulta($multa)
    {
        $this->multa = $multa;
    }

    /**
     * @param mixed $desconto
     */
    public function setDesconto(Desconto $desconto)
    {
        $this->desconto = $desconto;
    }

    /**
     * @param mixed $mensagens_cobranca
     */
    public function setMensagensCobranca(MensagemCobranca $mensagens_cobranca)
    {
        $this->mensagens_cobranca[] = $mensagens_cobranca;
    }

    /**
     * @param mixed $recebimento_divergente
     */
    public function setRecebimentoDivergente(RecebimentoDivergente $recebimento_divergente)
    {
        $this->recebimento_divergente = $recebimento_divergente;
    }

    /**
     * @param mixed $pagamentos_cobranca
     */
    public function setPagamentosCobranca(PagamentoCobranca $pagamentos_cobranca)
    {
        $this->pagamentos_cobranca[] = $pagamentos_cobranca;
    }

    /**
     * @param mixed $historico
     */
    public function setHistorico(Historico $historico)
    {
        $this->historico[] = $historico;
    }

    /**
     * @param mixed $baixa
     * @return DadoBoleto
     */
    public function setBaixa($baixa)
    {
        $this->baixa = $baixa;
    }





}