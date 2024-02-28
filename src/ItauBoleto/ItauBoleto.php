<?php

namespace Alexandreo\ItauBoleto;

use Alexandreo\ItauBoleto\Client\Client;
use Alexandreo\ItauBoleto\Client\ItauRequest;
use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\PostBoletosRequest;
use Alexandreo\ItauBoleto\Client\Response;
use Alexandreo\ItauBoleto\Constants\ItauLayout;

/**
 *
 */
class ItauBoleto
{

    protected $config = [];

    private $client;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
         $this->configure($config);
         $this->client = new Client($this->config);
    }

    /**
     * @param array $config
     * @return void
     */
    private function configure(array $config)
    {
        $defaultConfig = [
            'clientId' => null,
            'clientSecret' => null,
            'itauKey' => null,
            'cnpj' => null,
            'cert' => null,
            'print' => null,
            'return' => null
        ];

        if (!empty($config['clientId'])) {
            $defaultConfig['clientId'] = $config['clientId'];
        }

        if (!empty($config['clientSecret'])) {
            $defaultConfig['clientSecret'] = $config['clientSecret'];
        }

        if (!empty($config['itauKey'])) {
            $defaultConfig['itauKey'] = $config['itauKey'];
        }

        if (!empty($config['cnpj'])) {
            $defaultConfig['cnpj'] = $config['cnpj'];
        }

        if (!empty($config['cert'])) {
            $defaultConfig['cert'] = $config['cert'];
        }

        if (!empty($config['print'])) {
            $defaultConfig['print'] = $config['print'];
        }

        if (!empty($config['return'])) {
            $defaultConfig['return'] = $config['return'];
        }

        $this->config = $defaultConfig;
    }

    public function registrar(ItauRequest $postBoletosRequest)
    {
        $response = $this->client->postBoleto($postBoletosRequest);

        return $response;
//
//        if ($this->config['print'] == ItauLayout::HTML) {
//            return Response::html($response);
//        }
    }

}