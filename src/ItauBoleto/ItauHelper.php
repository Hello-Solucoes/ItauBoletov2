<?php

namespace Alexandreo\ItauBoleto;

/**
 *
 */
class ItauHelper
{

    /**
     * @param $data
     * @return string|void
     * @throws \Random\RandomException
     */
    static function guidv4($data = null) {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


    /**
     * @param $valor
     * @return array|string|string[]
     */
    static function formatValor($valor)
    {
        return str_replace('.', '', sprintf('%015.2f', $valor));
    }

    static function responseFormatValue($valor)
    {
        $valor_formatado = sprintf('%015.2f', $valor); // Formata o número com 15 dígitos inteiros e 2 casas decimais
        $valor_formatado = str_replace('.', '', $valor_formatado); // Remove o ponto decimal
        $valor_decimal = floatval(substr($valor_formatado, 0, -2) . '.' . substr($valor_formatado, -2)); // Reverte para o formato decimal
        echo $valor_decimal;
    }

}