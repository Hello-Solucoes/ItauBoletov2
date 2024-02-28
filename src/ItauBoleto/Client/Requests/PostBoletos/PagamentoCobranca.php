<?php

namespace Alexandreo\ItauBoleto\Client\Requests\PostBoletos;

class PagamentoCobranca implements \Alexandreo\ItauBoleto\Client\ItauRequest
{

    public $codigo_instituicao_financeira_pagamento;
    public $codigo_identificador_sistema_pagamento_brasileiro;
    public $numero_agencia_recebedora;
    public $codigo_canal_pagamento_boleto_cobranca;
    public $codigo_meio_pagamento_boleto_cobranca;
    public $valor_pago_total_cobranca;
    public $valor_pago_desconto_cobranca;
    public $valor_pago_multa_cobranca;
    public $valor_pago_juro_cobranca;
    public $valor_pago_abatimento_cobranca;
    public $valor_pagamento_imposto_sobre_operacao_financeira;
    public $data_hora_inclusao_pagamento;
    public $data_inclusao_pagamento;
    public $descricao_meio_pagamento;
    public $descricao_canal_pagamento;


}

