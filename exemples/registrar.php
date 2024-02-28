<?php

require '../vendor/autoload.php';

use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\AcoesPermitidas;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Beneficiario;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\DadoBoleto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\DadosIndividuaisBoleto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Desconto;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Descontos;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Endereco;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Historico;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Juros;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\MensagemCobranca;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Multa;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Pagador;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\Pessoa;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\PostBoletosRequest;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\RecebimentoDivergente;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\TipoPessoa;
use Alexandreo\ItauBoleto\ItauBoleto;

$postBoletosRequest = new PostBoletosRequest;
$postBoletosRequest->id_boleto = '8702edc0-d561-498f-9f6e-08e1e18b3516';
$postBoletosRequest->etapa_processo_boleto = 'EFETIVACAO';
$postBoletosRequest->codigo_canal_operacao = 'API';

$beneficiario = new Beneficiario;
$beneficiario->id_beneficiario = '018900009269';
$beneficiario->nome_cobranca = 'Hello World';
//CPF - Obrigatório caso tipo_pessoa = F
//CNPJ - Obrigatório caso tipo_pessoa = J
$tipoPessoa = new TipoPessoa;
$tipoPessoa->codigo_tipo_pessoa = 'J';
$tipoPessoa->numero_cadastro_nacional_pessoa_juridica = '35775534000174';
$beneficiario->setTipoPessoa($tipoPessoa);
$endereco = new Endereco;
$endereco->nome_logradouro = 'Rua do Test';
$endereco->nome_cidade = 'São Paulo';
$endereco->sigla_UF = 'SP';
$endereco->numero_CEP = '0146918';
$beneficiario->setEndereco($endereco);
$postBoletosRequest->setBeneficiario($beneficiario);

$dadoBoleto = new DadoBoleto;
$dadoBoleto->descricao_instrumento_cobranca = 'boleto';
//Identifica o tipo do boleto. Se for emitir mais de um boleto, preencher com 'parcelado'.
// Senão, se for emitir um boleto de proposta, preencher com 'proposta'.
// Senão, se for emitir um boleto a vista, preencher com 'a vista'
$dadoBoleto->tipo_boleto = 'a vista';
$dadoBoleto->codigo_tipo_vencimento = 3;
$dadoBoleto->codigo_especie = '01';
$dadoBoleto->desconto_expresso = false;
$dadoBoleto->data_emissao = date('Y-m-d');
//DadosIndividuaisBoleto
$dadosIndividuaisBoleto = new DadosIndividuaisBoleto();
$dadosIndividuaisBoleto->id_boleto_individual = '8702edc0-d561-498f-9f6e-08e1e18b3515';
$dadosIndividuaisBoleto->valor_titulo = 100.00;
$dadosIndividuaisBoleto->data_vencimento = '2024-03-20';
$dadosIndividuaisBoleto->data_limite_pagamento = '2024-03-20';
$dadosIndividuaisBoleto->numero_nosso_numero = '273478236';
$dadosIndividuaisBoleto->status_vencimento = 'a vencer';
//$MensagemCobranca = new MensagemCobranca();

$dadoBoleto->setDadosIndividuaisBoleto($dadosIndividuaisBoleto);

$pagador = new Pagador();
$pagador->id_pagador = uniqid();
$pessoa = new Pessoa();
$pessoa->nome_pessoa = 'Hello Solucoes LTDA';
$pessoa->nome_fantasia = 'Hello Solucoes LTDA';
$tipoPessoa = new TipoPessoa();
$tipoPessoa->codigo_tipo_pessoa = 'J';
$tipoPessoa->numero_cadastro_nacional_pessoa_juridica = '35775534000174';
$pessoa->setTipoPessoa($tipoPessoa);
$pagador->setPessoa($pessoa);
$dadoBoleto->setPagador($pagador);

$juros = new Juros;
$juros->codigo_tipo_juros = '05';
$dadoBoleto->setJuros($juros);

$multa = new Multa;
$multa->codigo_tipo_multa = '01';
$multa->valor_multa = 1.00;
$dadoBoleto->setMulta($multa);

//$desconto = new Desconto;
//$desconto->codigo_tipo_desconto = '00';
//$descontos = new Descontos;
//$descontos->quantidade_dias_desconto = 0;
//$desconto->setDescontos($descontos);
//$dadoBoleto->setDesconto($desconto);

$recebimentoDivergente = new RecebimentoDivergente();
$recebimentoDivergente->codigo_tipo_autorizacao = '01';
$dadoBoleto->setRecebimentoDivergente($recebimentoDivergente);

$historico = new Historico();
$historico->data = '2024-03-20';
$historico->operacao = 'nova operacao';
$historico->comandado_por = 'alexandre';
$dadoBoleto->setHistorico($historico);

$acoesPermitidas = new AcoesPermitidas();
$acoesPermitidas->emitir_segunda_via = true;
$acoesPermitidas->comandar_instrucao_alterar_dados_cobranca = true;

$postBoletosRequest->setAcoesPermitidas($acoesPermitidas);
$postBoletosRequest->setDadoBoleto($dadoBoleto);


$itauBoleto = new ItauBoleto([
    'clientId' => 'XXXXX',
    'clientSecret' => 'XXXXXX',
    'itauKey' => 'XXXXXX',
    'cnpj' => 'XXXXXX',
    'production' => true,
    'cert' => __DIR__ . '/../server.pem',
//    'print' => Layout::HTML,
//    'return' => Retorno::TO_OBJECT
]);

$boleto = $itauBoleto->postBoleto($postBoletosRequest);

var_dump($boleto);