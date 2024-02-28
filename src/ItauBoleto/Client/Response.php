<?php

namespace Alexandreo\ItauBoleto\Client;

use Alexandreo\ItauBoleto\Constants\ItauTipoPessoa;
use Alexandreo\ItauBoleto\ItauHelper;
use NovoBoletoPHP\BoletoFactory;

class Response
{

    public static function html(array $response)
    {
        $factory = new BoletoFactory;

//        var_dump(json_encode($response));exit;

        $tipoPessoaPagador = $response['data']['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['codigo_tipo_pessoa'] ?? null;
        $tipoPessoaBeneficiario = $response['data']['beneficiario']['tipo_pessoa']['codigo_tipo_pessoa'] ?? null;
        $sacado = '';
        $sacado_documento = '';
        $sacado_documento_beneficiario = '';
        $endereco1 = '';
        $endereco2 = '';
        $endereco1_beneficiario  = '';
        $endereco2_beneficiario  = '';
        $codigo_barras = '';
        $numero_linha_digitavel = '';


        if ($tipoPessoaPagador == ItauTipoPessoa::FISICA) {
            $sacado = $response['data']['dado_boleto']['pagador']['pessoa']['nome_pessoa'] ?? null;
            $sacado_documento = $response['data']['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['numero_cadastro_pessoa_fisica'] ?? null;
        }

        if ($tipoPessoaPagador == ItauTipoPessoa::JURIDICA) {
            $sacado = $response['data']['dado_boleto']['pagador']['pessoa']['nome_fantasia'] ?? null;
            $sacado_documento = $response['data']['dado_boleto']['pagador']['pessoa']['tipo_pessoa']['numero_cadastro_nacional_pessoa_juridica'] ?? null;
        }

        if ($tipoPessoaBeneficiario == ItauTipoPessoa::FISICA) {
            $sacado_documento_beneficiario = $response['data']['beneficiario']['tipo_pessoa']['numero_cadastro_pessoa_fisica'] ?? null;
        }

        if ($tipoPessoaBeneficiario == ItauTipoPessoa::JURIDICA) {
            $sacado_documento_beneficiario = $response['data']['beneficiario']['tipo_pessoa']['numero_cadastro_nacional_pessoa_juridica'] ?? null;
        }


        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['nome_logradouro'])) {
            $endereco1 = $response['data']['dado_boleto']['pagador']['endereco']['nome_logradouro'];
        }

        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['nome_bairro'])) {
            $endereco1 .= ' ' . $response['data']['dado_boleto']['pagador']['endereco']['nome_bairro'];
        }

        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['nome_bairro'])) {
            $endereco1 .= ' ' . $response['data']['dado_boleto']['pagador']['endereco']['nome_bairro'];
        }

        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['nome_cidade'])) {
            $endereco2 .= ' ' . $response['data']['dado_boleto']['pagador']['endereco']['nome_cidade'];
        }

        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['sigla_UF'])) {
            $endereco2 .= ' - ' .$response['data']['dado_boleto']['pagador']['endereco']['sigla_UF'];
        }

        if (!empty($response['data']['dado_boleto']['pagador']['endereco']['numero_CEP'])) {
            $endereco2 .= ' CEP ' .$response['data']['dado_boleto']['pagador']['endereco']['numero_CEP'];
        }


        if (!empty($response['data']['beneficiario']['endereco']['nome_logradouro'])) {
            $endereco1_beneficiario = $response['data']['beneficiario']['endereco']['nome_logradouro'];
        }

        if (!empty($response['data']['beneficiario']['endereco']['nome_bairro'])) {
            $endereco1_beneficiario .= ' ' . $response['data']['beneficiario']['endereco']['nome_bairro'];
        }

        if (!empty($response['data']['beneficiario']['endereco']['numero'])) {
            $endereco1_beneficiario .= ' ' . $response['data']['beneficiario']['endereco']['numero'];
        }

        if (!empty($response['data']['beneficiario']['endereco']['numero_CEP'])) {
            $endereco1_beneficiario .= ' CEP ' . $response['data']['beneficiario']['endereco']['numero_CEP'];
        }


        if (!empty($response['data']['beneficiario']['endereco']['nome_cidade'])) {
            $endereco2_beneficiario .= $response['data']['beneficiario']['endereco']['nome_cidade'];
        }

        if (!empty($response['data']['beneficiario']['endereco']['sigla_UF'])) {
            $endereco2_beneficiario .= ' - ' .$response['data']['beneficiario']['endereco']['sigla_UF'];
        }


        $agencia = substr($response['data']['beneficiario']['id_beneficiario'], 0, 4);
        $conta = substr($response['data']['beneficiario']['id_beneficiario'], 4, 7);
        $conta_dv = substr($response['data']['beneficiario']['id_beneficiario'], -1);


        if (!empty($response['data']['dado_boleto']['dados_individuais_boleto'][0]['codigo_barras'])) {
            $codigo_barras = $response['data']['dado_boleto']['dados_individuais_boleto'][0]['codigo_barras'] ?? null;
        }

        if (!empty($response['data']['dado_boleto']['dados_individuais_boleto'][0]['numero_linha_digitavel'])) {
            $numero_linha_digitavel = $response['data']['dado_boleto']['dados_individuais_boleto'][0]['numero_linha_digitavel'] ?? null;
        }


        $data = array(
            'nosso_numero' => $response['data']['dado_boleto']['dados_individuais_boleto'][0]['numero_nosso_numero'] ?? null,
            'numero_documento' => $response['data']['dado_boleto']['dados_individuais_boleto'][0]['id_boleto_individual'] ?? null,
            'data_vencimento' => date('d/m/Y', strtotime($response['data']['dado_boleto']['dados_individuais_boleto'][0]['data_vencimento'])) ?? null,
            'data_documento' => date('d/m/Y', strtotime($response['data']['dado_boleto']['dados_individuais_boleto'][0]['data_emissao'])) ?? null,
            'data_processamento' => date('d/m/Y', strtotime($response['data']['dado_boleto']['dados_individuais_boleto'][0]['data_emissao'])) ?? null,
            'valor_boleto' => ItauHelper::responseFormatValue($response['data']['dado_boleto']['dados_individuais_boleto'][0]['valor_titulo']) ?? null,
            'carteira' => $response['data']['dado_boleto']['codigo_carteira'] ?? null,
            'variacao_carteira' => '27',
            'especie_doc' => $response['data']['dado_boleto']['codigo_especie'] ?? null,
            'sacado' => $sacado,
            'sacado_documento' => $sacado_documento,
            'endereco1' => $endereco1,
            'endereco2' => $endereco2,
            'instrucoes1' => 'Não receber após vencimento',
            'aceite' => 'N',
            'especie' => 'R$',
            'agencia' => $agencia, // Num da agencia, sem digito
            'conta' => $conta, // Num da conta, sem digito
            'conta_dv' => $conta_dv,
            'codigo_barras' => $codigo_barras,
            'numero_linha_digitavel' => $numero_linha_digitavel,
            'identificacao' => $response['data']['beneficiario']['nome_cobranca'] ?? null,
            'cpf_cnpj' => $sacado_documento_beneficiario,
            'endereco' => $endereco1_beneficiario,
            'cidade_uf' => $endereco2_beneficiario,
            'cedente' => $response['data']['beneficiario']['nome_cobranca'] ?? null,
            'logo_empresa' => 'http://placehold.it/200&text=logo',
        );


        return $factory->makeBoletoAsHTML(BoletoFactory::ITAU, $data);


    }

}

//"nome_logradouro": "Rua camaraje,71",
//          "nome_bairro": "Mandaqui",
//          "nome_cidade": "SAO PAULO",
//          "sigla_UF": "SP",
//          "numero_CEP": "02416060"