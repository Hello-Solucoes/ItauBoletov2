<?php

namespace Alexandreo\ItauBoleto\Factories;

use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\AcoesPermitidas;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Baixa;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Beneficiario;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Campos;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\DadoBoleto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\DadosIndividuaisBoleto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Desconto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Descontos;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Detalhe;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Endereco;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Historico;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\InstrucaoCobranca;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Juros;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\MensagemCobranca;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Multa;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Negativacao;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Pagador;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\PagamentoCobranca;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Pessoa;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\PostBoletosRequest;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Protesto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\RecebimentoDivergente;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\SacadorAvalista;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\TipoPessoa;
use Alexandreo\ItauBoleto\Constants\ItauTipoPessoa;

/**
 *
 */
class RegistrarRequest
{

    /**
     * @throws \Exception
     */
    public static function create(array $data)
    {
        $postBoletosRequest = new PostBoletosRequest();
        self::make($postBoletosRequest, $data);
        self::makeBeneficiario($postBoletosRequest, $data);
        self::makeDadoBoleto($postBoletosRequest, $data);
        self::makeAcoesPermitidas($postBoletosRequest, $data);

        return $postBoletosRequest;
    }

    /**
     * @param PostBoletosRequest $postBoletosRequest
     * @param array $data
     * @return void
     */
    private static function make(PostBoletosRequest &$postBoletosRequest, array $data)
    {
        $postBoletosRequest->id_boleto = $data['id_boleto'] ?? null;
        $postBoletosRequest->etapa_processo_boleto = $data['etapa_processo_boleto'] ?? null;
        $postBoletosRequest->codigo_canal_operacao = $data['codigo_canal_operacao'] ?? null;
    }

    /**
     * @param $codigoTipoPessoa
     * @param $doc
     * @return TipoPessoa
     * @throws \Exception
     */
    private static function pessoa($codigoTipoPessoa, $doc)
    {
        $tipoPessoa = new TipoPessoa();
        $tipoPessoa->codigo_tipo_pessoa = $codigoTipoPessoa;
        switch ($codigoTipoPessoa) {
            case ItauTipoPessoa::FISICA:
                $tipoPessoa->numero_cadastro_pessoa_fisica = $doc;
            break;
            case ItauTipoPessoa::JURIDICA:
                $tipoPessoa->numero_cadastro_nacional_pessoa_juridica = $doc;
            break;
            default:
                throw new \Exception('Tipo de pessoa inválido');
            break;
        }

        return $tipoPessoa;
    }

    /**
     * @param PostBoletosRequest $postBoletosRequest
     * @param array $data
     * @return void
     * @throws \Exception
     */
    private static function makeBeneficiario(PostBoletosRequest &$postBoletosRequest, array $data)
    {
        $beneficiario = new Beneficiario();
        $beneficiario->id_beneficiario = $data['beneficiario']['id_beneficiario'] ?? null;
        $beneficiario->nome_cobranca = $data['beneficiario']['nome_cobranca'] ?? null;

        if (!empty($data['beneficiario']['tipo_pessoa'])) {
            $codigoTipoPessoa = $data['beneficiario']['tipo_pessoa']['codigo_tipo_pessoa'] ?? null;
            $doc = 0;

            if ($codigoTipoPessoa === ItauTipoPessoa::FISICA) {
                $doc = $data['beneficiario']['tipo_pessoa']['numero_cadastro_pessoa_fisica'] ?? null;
            }

            if ($codigoTipoPessoa === ItauTipoPessoa::JURIDICA) {
                $doc = $data['beneficiario']['tipo_pessoa']['numero_cadastro_nacional_pessoa_juridica'] ?? null;
            }

            $beneficiario->setTipoPessoa(self::pessoa($codigoTipoPessoa, $doc));
        }

        if (!empty($data['beneficiario']['endereco'])) {
            $endereco = new Endereco();
            $endereco->nome_logradouro = $data['beneficiario']['endereco']['nome_logradouro'] ?? null;
            $endereco->nome_cidade = $data['beneficiario']['endereco']['nome_cidade'] ?? null;
            $endereco->sigla_UF = $data['beneficiario']['endereco']['sigla_UF'] ?? null;
            $endereco->numero_CEP = $data['beneficiario']['endereco']['numero_CEP'] ?? null;
            $beneficiario->setEndereco($endereco);
        }


        $postBoletosRequest->setBeneficiario($beneficiario);
    }

    /**
     * @param PostBoletosRequest $postBoletosRequest
     * @param array $data
     * @return void
     * @throws \Exception
     */
    private static function makeDadoBoleto(PostBoletosRequest &$postBoletosRequest, array $data)
    {
        $dadoBoleto = new DadoBoleto;
        $dadoBoleto->descricao_instrumento_cobranca = $data['dado_boleto']['descricao_instrumento_cobranca'] ?? null;
        $dadoBoleto->tipo_boleto = $data['dado_boleto']['tipo_boleto'] ?? null;
        $dadoBoleto->forma_envio = $data['dado_boleto']['forma_envio'] ?? null;
        $dadoBoleto->quantidade_parcelas = $data['dado_boleto']['quantidade_parcelas'] ?? null;
        $dadoBoleto->codigo_carteira = $data['dado_boleto']['codigo_carteira'] ?? null;
        $dadoBoleto->codigo_tipo_vencimento = $data['dado_boleto']['codigo_tipo_vencimento'] ?? null;
        $dadoBoleto->valor_total_titulo = $data['dado_boleto']['valor_total_titulo'] ?? null;
        $dadoBoleto->codigo_especie = $data['dado_boleto']['codigo_especie'] ?? null;
        $dadoBoleto->descricao_especie = $data['dado_boleto']['descricao_especie'] ?? null;
        $dadoBoleto->codigo_aceite = $data['dado_boleto']['codigo_aceite'] ?? null;
        $dadoBoleto->data_emissao = $data['dado_boleto']['data_emissao'] ?? null;
        $dadoBoleto->pagamento_parcial = $data['dado_boleto']['pagamento_parcial'] ?? null;
        $dadoBoleto->valor_abatimento = $data['dado_boleto']['valor_abatimento'] ?? null;
        $dadoBoleto->quantidade_maximo_parcial = $data['dado_boleto']['quantidade_maximo_parcial'] ?? null;
        $dadoBoleto->desconto_expresso = $data['dado_boleto']['desconto_expresso'] ?? null;
        $dadoBoleto->texto_uso_beneficiario = $data['dado_boleto']['texto_uso_beneficiario'] ?? null;

        if (!empty($data['dado_boleto']['protesto'])) {
            $protesto = new Protesto();
            $protesto->codigo_tipo_protesto = $data['dado_boleto']['protesto']['codigo_tipo_protesto'] ?? null;
            $protesto->quantidade_dias_protesto = $data['dado_boleto']['protesto']['quantidade_dias_protesto'] ?? null;
            $protesto->protesto_falimentar = $data['dado_boleto']['protesto']['protesto_falimentar'] ?? null;
            $dadoBoleto->setProtesto($protesto);
        }

        if (!empty($data['dado_boleto']['negativacao'])) {
            $negativacao = new Negativacao();
            $negativacao->codigo_tipo_negativacao = $data['dado_boleto']['negativacao']['codigo_tipo_negativacao'] ?? null;
            $negativacao->quantidade_dias_negativacao = $data['dado_boleto']['negativacao']['quantidade_dias_negativacao'] ?? null;
            $dadoBoleto->setNegativacao($negativacao);
        }

        if (!empty($data['dado_boleto']['instrucao_cobranca']) && is_array($data['dado_boleto']['instrucao_cobranca'])) {
            foreach ($data['dado_boleto']['instrucao_cobranca'] as $instrucao) {
                $instrucaoCobranca = new InstrucaoCobranca();
                $instrucaoCobranca->codigo_instrucao_cobranca = $instrucao['codigo_instrucao_cobranca'] ?? null;
                $instrucaoCobranca->quantidade_dias_instrucao_cobranca = $instrucao['quantidade_dias_instrucao_cobranca'] ?? null;
                $instrucaoCobranca->dia_util = $instrucao['dia_util'] ?? null;
                $dadoBoleto->setInstrucaoCobranca($instrucaoCobranca);
            }
        }

        if (!empty($data['dado_boleto']['pagador'])) {
            $pagador = new Pagador();
            $pagador->id_pagador = $data['dado_boleto']['pagador']['id_pagador'] ?? null;
            $pagador->texto_endereco_email = $data['dado_boleto']['pagador']['texto_endereco_email'] ?? null;
            $pagador->numero_ddd = $data['dado_boleto']['pagador']['numero_ddd'] ?? null;
            $pagador->numero_telefone = $data['dado_boleto']['pagador']['numero_telefone'] ?? null;
            $pagador->data_hora_inclusao_alteracao = $data['dado_boleto']['pagador']['data_hora_inclusao_alteracao'] ?? null;

            if (!empty($data['dado_boleto']['pagador']['pessoa'])) {
                $pessoa = new Pessoa();
                $doc = 0;

                $codigoTipoPessoa = $data['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['codigo_tipo_pessoa'] ?? null;

                //precisa da pessoa sempre como pagador
                $pessoa->nome_pessoa = $data['dado_boleto']['pagador']['pessoa']['nome_pessoa'] ?? null;
                $pessoa->nome_fantasia = $data['dado_boleto']['pagador']['pessoa']['nome_fantasia'] ?? null;

                if ($codigoTipoPessoa === ItauTipoPessoa::FISICA) {
                    $doc = $data['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['numero_cadastro_pessoa_fisica'] ?? null;
                }

                if ($codigoTipoPessoa === ItauTipoPessoa::JURIDICA) {
                    $doc = $data['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['numero_cadastro_nacional_pessoa_juridica'] ?? null;
                }
                $pessoa->setTipoPessoa(self::pessoa($codigoTipoPessoa, $doc));
                $pagador->setPessoa($pessoa);
            }

            if (!empty($data['dado_boleto']['pagador']['endereco'])) {
                $endereco = new Endereco();
                $endereco->nome_logradouro = $data['dado_boleto']['pagador']['endereco']['nome_logradouro'] ?? null;
                $endereco->nome_cidade = $data['dado_boleto']['pagador']['endereco']['nome_cidade'] ?? null;
                $endereco->nome_bairro = $data['dado_boleto']['pagador']['endereco']['nome_bairro'] ?? null;
                $endereco->sigla_UF = $data['dado_boleto']['pagador']['endereco']['sigla_UF'] ?? null;
                $endereco->numero_CEP = $data['dado_boleto']['pagador']['endereco']['numero_CEP'] ?? null;
                $pagador->setEndereco($endereco);
            }
            $dadoBoleto->setPagador($pagador);
        }

        if (!empty($data['dado_boleto']['sacador_avalista'])) {
            $sacadorAvallista = new SacadorAvalista();
            $sacadorAvallista->exclusao_sacador_avalista = $data['dado_boleto']['sacador_avalista']['exclusao_sacador_avalista'] ?? null;
            if (!empty($data['dado_boleto']['sacador_avalista']['pessoa'])) {
                $pessoa = new Pessoa();
                $doc = 0;

                $codigoTipoPessoa = $data['dado_boleto']['sacador_avalista']['pessoa']['tipo_pessoa']['codigo_tipo_pessoa'] ?? null;

                if ($codigoTipoPessoa === ItauTipoPessoa::FISICA) {
                    $pessoa->nome_pessoa = $data['dado_boleto']['sacador_avalista']['pessoa']['nome_pessoa'] ?? null;
                    $doc = $data['dado_boleto']['sacador_avalista']['pessoa']['tipo_pessoa']['codigo_tipo_pessoa']['numero_cadastro_pessoa_fisica'] ?? null;
                }

                if ($codigoTipoPessoa === ItauTipoPessoa::JURIDICA) {
                    $pessoa->nome_fantasia = $data['dado_boleto']['sacador_avalista']['pessoa']['nome_fantasia'] ?? null;
                    $doc = $data['dado_boleto']['sacador_avalista']['pessoa']['tipo_pessoa']['codigo_tipo_pessoa']['numero_cadastro_nacional_pessoa_juridica'] ?? null;
                }
                $pessoa->setTipoPessoa(self::pessoa($codigoTipoPessoa, $doc));
                $sacadorAvallista->setPessoa($pessoa);
            }

            if (!empty($data['dado_boleto']['sacador_avalista']['endereco'])) {
                $endereco = new Endereco();
                $endereco->nome_logradouro = $data['dado_boleto']['sacador_avalista']['endereco']['nome_logradouro'] ?? null;
                $endereco->nome_cidade = $data['dado_boleto']['sacador_avalista']['endereco']['nome_cidade'] ?? null;
                $endereco->sigla_UF = $data['dado_boleto']['sacador_avalista']['endereco']['sigla_UF'] ?? null;
                $endereco->numero_CEP = $data['dado_boleto']['sacador_avalista']['endereco']['numero_CEP'] ?? null;
                $sacadorAvallista->setEndereco($endereco);
            }
        }

        if (!empty($data['dado_boleto']['dados_individuais_boleto']) && is_array($data['dado_boleto']['dados_individuais_boleto'])) {
            foreach ($data['dado_boleto']['dados_individuais_boleto'] as $dadosIndividuaisBoleto) {
                $dadoBoletoIndividual = new DadosIndividuaisBoleto();
                $dadoBoletoIndividual->id_boleto_individual = $dadosIndividuaisBoleto['id_boleto_individual'] ?? null;
                $dadoBoletoIndividual->valor_titulo = $dadosIndividuaisBoleto['valor_titulo'] ?? null;
                $dadoBoletoIndividual->data_vencimento = $dadosIndividuaisBoleto['data_vencimento'] ?? null;
                $dadoBoletoIndividual->data_limite_pagamento = $dadosIndividuaisBoleto['data_limite_pagamento'] ?? null;
                $dadoBoletoIndividual->numero_nosso_numero = $dadosIndividuaisBoleto['numero_nosso_numero'] ?? null;
                $dadoBoletoIndividual->status_vencimento = $dadosIndividuaisBoleto['status_vencimento'] ?? null;

                if (!empty($data['dado_boleto']['dados_individuais_boleto']['mensagens_cobranca']) && is_array($data['dado_boleto']['dados_individuais_boleto']['mensagens_cobranca'])) {
                    foreach ($data['dado_boleto']['dados_individuais_boleto']['mensagens_cobranca'] as $mensagemCobranca) {
                        $mensagemCobranca = new MensagemCobranca();
                        $mensagemCobranca->mensagem = $mensagemCobranca['mensagem'] ?? null;
                        $dadoBoletoIndividual->setMensagensCobranca($mensagemCobranca);
                    }
                }

                $dadoBoleto->setDadosIndividuaisBoleto($dadoBoletoIndividual);
            }
        }

        if (!empty($data['dado_boleto']['juros'])) {
            $juros = new Juros();
            $juros->codigo_tipo_juros = $data['dado_boleto']['juros']['codigo_tipo_juros'] ?? null;
            $juros->quantidade_dias_juros = $data['dado_boleto']['juros']['quantidade_dias_juros'] ?? null;
            $juros->valor_juros = $data['dado_boleto']['juros']['valor_juros'] ?? null;
            $juros->percentual_juros = $data['dado_boleto']['juros']['percentual_juros'] ?? null;
            $juros->data_juros = $data['dado_boleto']['juros']['data_juros'] ?? null;
            $dadoBoleto->setJuros($juros);
        }

        if (!empty($data['dado_boleto']['multa'])) {
            $multa = new Multa();
            $multa->codigo_tipo_multa = $data['dado_boleto']['multa']['codigo_tipo_multa'] ?? null;
            $multa->quantidade_dias_multa = $data['dado_boleto']['multa']['quantidade_dias_multa'] ?? null;
            $multa->valor_multa = $data['dado_boleto']['multa']['valor_multa'] ?? null;
            $multa->percentual_multa = $data['dado_boleto']['multa']['percentual_multa'] ?? null;
            $dadoBoleto->setMulta($multa);
        }

        if (!empty($data['dado_boleto']['desconto'])) {
            $desconto = new Desconto();
            $desconto->codigo_tipo_desconto = $data['dado_boleto']['desconto']['codigo_tipo_desconto'] ?? null;
            $desconto->codigo = $data['dado_boleto']['desconto']['codigo'] ?? null;
            $desconto->mensagem = $data['dado_boleto']['desconto']['mensagem'] ?? null;

            if (!empty($data['dado_boleto']['desconto']['descontos']) && is_array($data['dado_boleto']['desconto']['descontos'])) {
                foreach ($data['dado_boleto']['desconto']['descontos'] as $dataDescontos) {
                    $descontos = new Descontos();
                    $descontos->quantidade_dias_desconto = $dataDescontos['quantidade_dias_desconto'] ?? null;
                    $descontos->valor_desconto = $dataDescontos['valor_desconto'] ?? null;
                    $descontos->percentual_desconto = $dataDescontos['percentual_desconto'] ?? null;
                    $desconto->setDescontos($descontos);
                }
            }

            if (!empty($data['dado_boleto']['desconto']['campos']) && is_array($data['dado_boleto']['desconto']['campos'])) {
                foreach ($data['dado_boleto']['desconto']['campos'] as $dataCampos) {
                    $campos = new Campos();
                    $campos->campo = $dataCampos['campo'] ?? null;
                    $campos->mensagem = $dataCampos['mensagem'] ?? null;
                    $campos->valor = $dataCampos['valor'] ?? null;
                    $desconto->setCampos($campos);
                }
            }
            $dadoBoleto->setDesconto($desconto);
        }

        if (!empty($data['dado_boleto']['mensagens_cobranca']) && is_array($data['dado_boleto']['mensagens_cobranca'])) {
            foreach ($data['dado_boleto']['mensagens_cobranca'] as $dataMensagemCobranca) {
                $mensagemCobranca = new MensagemCobranca();
                $mensagemCobranca->mensagem = $dataMensagemCobranca['mensagem'] ?? null;
                $dadoBoleto->setMensagensCobranca($mensagemCobranca);
            }
        }

        if (!empty($data['dado_boleto']['recebimento_divergente'])) {
            $recebimentoDivergente = new RecebimentoDivergente();
            $recebimentoDivergente->codigo_tipo_autorizacao = $data['dado_boleto']['recebimento_divergente']['codigo_tipo_autorizacao'] ?? null;
            $recebimentoDivergente->percentual_maximo = $data['dado_boleto']['recebimento_divergente']['percentual_maximo'] ?? null;
            $recebimentoDivergente->percentual_minimo = $data['dado_boleto']['recebimento_divergente']['percentual_minimo'] ?? null;
            $recebimentoDivergente->valor_maximo = $data['dado_boleto']['recebimento_divergente']['valor_maximo'] ?? null;
            $recebimentoDivergente->valor_minimo = $data['dado_boleto']['recebimento_divergente']['valor_minimo'] ?? null;
            $dadoBoleto->setRecebimentoDivergente($recebimentoDivergente);
        }


        if (!empty($data['dado_boleto']['pagamentos_cobranca']) && is_array($data['dado_boleto']['pagamentos_cobranca'])) {
            foreach ($data['dado_boleto']['pagamentos_cobranca'] as $dataPagamentoCobranca) {
                $pagamentoCobranca = new PagamentoCobranca();
                $pagamentoCobranca->codigo_instituicao_financeira_pagamento = $dataPagamentoCobranca['codigo_instituicao_financeira_pagamento'] ?? null;
                $pagamentoCobranca->codigo_identificador_sistema_pagamento_brasileiro = $dataPagamentoCobranca['codigo_identificador_sistema_pagamento_brasileiro'] ?? null;
                $pagamentoCobranca->numero_agencia_recebedora = $dataPagamentoCobranca['numero_agencia_recebedora'] ?? null;
                $pagamentoCobranca->codigo_canal_pagamento_boleto_cobranca = $dataPagamentoCobranca['codigo_canal_pagamento_boleto_cobranca'] ?? null;
                $pagamentoCobranca->codigo_meio_pagamento_boleto_cobranca = $dataPagamentoCobranca['codigo_meio_pagamento_boleto_cobranca'] ?? null;
                $pagamentoCobranca->valor_pago_total_cobranca = $dataPagamentoCobranca['valor_pago_total_cobranca'] ?? null;
                $pagamentoCobranca->valor_pago_desconto_cobranca = $dataPagamentoCobranca['valor_pago_desconto_cobranca'] ?? null;
                $pagamentoCobranca->valor_pago_multa_cobranca = $dataPagamentoCobranca['valor_pago_multa_cobranca'] ?? null;
                $pagamentoCobranca->valor_pago_juro_cobranca = $dataPagamentoCobranca['valor_pago_juro_cobranca'] ?? null;
                $pagamentoCobranca->valor_pago_abatimento_cobranca = $dataPagamentoCobranca['valor_pago_abatimento_cobranca'] ?? null;
                $pagamentoCobranca->valor_pagamento_imposto_sobre_operacao_financeira = $dataPagamentoCobranca['valor_pagamento_imposto_sobre_operacao_financeira'] ?? null;
                $pagamentoCobranca->data_hora_inclusao_pagamento = $dataPagamentoCobranca['data_hora_inclusao_pagamento'] ?? null;
                $pagamentoCobranca->descricao_meio_pagamento = $dataPagamentoCobranca['descricao_meio_pagamento'] ?? null;
                $pagamentoCobranca->descricao_canal_pagamento = $dataPagamentoCobranca['descricao_canal_pagamento'] ?? null;

                $dadoBoleto->setPagamentosCobranca($pagamentoCobranca);
            }
        }

        if (!empty($data['dado_boleto']['historico'])) {
            $historico = new Historico();
            $historico->comandado_por = $data['dado_boleto']['historico']['comandado_por'] ?? null;
            $historico->conteudo_anterior = $data['dado_boleto']['historico']['conteudo_anterior'] ?? null;
            $historico->conteudo_atual = $data['dado_boleto']['historico']['conteudo_atual'] ?? null;
            $historico->data = $data['dado_boleto']['historico']['data'] ?? null;
            $historico->motivo = $data['dado_boleto']['historico']['motivo'] ?? null;
            $historico->operacao = $data['dado_boleto']['historico']['operacao'] ?? null;


            if (!empty($data['dado_boleto']['historico']['detalhe']) && is_array($data['dado_boleto']['historico']['detalhe'])) {
                foreach ($data['dado_boleto']['historico']['detalhe'] as $dataDetalhe) {
                    $detalhe = new Detalhe();
                    $detalhe->conteudo_anterior = $dataDetalhe['conteudo_anterior'] ?? null;
                    $detalhe->conteudo_atual = $dataDetalhe['conteudo_atual'] ?? null;
                    $detalhe->descricao = $dataDetalhe['descricao'] ?? null;
                    $historico->setDetalhe($detalhe);
                }
            }

            $dadoBoleto->setHistorico($historico);
        }

        if (!empty($data['dado_boleto']['baixa'])) {
            $baixa = new Baixa();
            $baixa->codigo = $data['dado_boleto']['baixa']['codigo'] ?? null;
            $baixa->codigo_motivo_boleto_cobranca_baixado = $data['dado_boleto']['baixa']['codigo_motivo_boleto_cobranca_baixado'] ?? null;
            $baixa->codigo_usuario_inclusao_alteracao = $data['dado_boleto']['baixa']['codigo_usuario_inclusao_alteracao'] ?? null;
            $baixa->data_hora_inclusao_alteracao_baixa = $data['dado_boleto']['baixa']['data_hora_inclusao_alteracao_baixa'] ?? null;
            $baixa->data_inclusao_alteracao_baixa = $data['dado_boleto']['baixa']['data_inclusao_alteracao_baixa'] ?? null;
            $baixa->indicador_dia_util_baixa = $data['dado_boleto']['baixa']['indicador_dia_util_baixa'] ?? null;
            $baixa->mensagem = $data['dado_boleto']['baixa']['mensagem'] ?? null;

            if (!empty($data['dado_boleto']['baixa']['campos']) && is_array($data['dado_boleto']['baixa']['campos'])) {
                foreach ($data['dado_boleto']['baixa']['campos'] as $dataCampos) {
                    $campos = new Campos();
                    $campos->campo = $dataCampos['campo'] ?? null;
                    $campos->mensagem = $dataCampos['mensagem'] ?? null;
                    $campos->valor = $dataCampos['valor'] ?? null;
                    $baixa->setCampos($campos);
                }
            }

            $dadoBoleto->setBaixa($baixa);
        }


        $postBoletosRequest->setDadoBoleto($dadoBoleto);
    }

    private static function makeAcoesPermitidas(PostBoletosRequest &$postBoletosRequest, array $data)
    {
        if (empty($data['acoes_permitidas']['comandar_instrucao_alterar_dados_cobranca'])) {
            return;
        }

        $acoesPermitidas = new AcoesPermitidas();
        $acoesPermitidas->comandar_instrucao_alterar_dados_cobranca = $data['acoes_permitidas']['comandar_instrucao_alterar_dados_cobranca'] ?? null;
        $acoesPermitidas->emitir_segunda_via = $data['acoes_permitidas']['emitir_segunda_via'] ?? null;

        $postBoletosRequest->setAcoesPermitidas($acoesPermitidas);

    }


}