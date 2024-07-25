<?php

namespace Alexandreo\ItauBoleto\Client;

use Alexandreo\ItauBoleto\Client\Requests\PostBoletos\PostBoletosRequest;
use Alexandreo\ItauBoleto\Constants\EndPoint;
use GuzzleHttp\Client as ClientGuzzle;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 *
 */
class Client extends ClientGuzzle
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $auth = [];

    /**
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        parent::__construct([
            'base_uri' => '',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ],
            'timeout' => 40,
            'connect_timeout' => 40
        ]);
        $this->authenticate();
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function authenticate()
    {
        if (empty($this->config['clientId']) || empty($this->config['clientSecret'])) {
            throw new \Exception('Client ID and Client Secret are required');
        }

        if (empty($this->config['itauKey'])) {
            throw new \Exception('Itau Key is required');
        }

        if (empty($this->config['cnpj'])) {
            throw new \Exception('CNPJ is required');
        }

        if (empty($this->config['cert'])) {
            throw new \Exception('Cert is required');
        }

        if (file_exists($this->config['cert']) === false) {
            throw new \Exception('Cert file not found');
        }

        try {
            $response = $this->post(EndPoint::OAuth, [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'cert' => $this->config['cert'],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->config['clientId'],
                    'client_secret' => $this->config['clientSecret']
                ]
            ]);
            $this->auth = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception('Error on authenticate');
        }
    }

    /**
     * @param PostBoletosRequest $postBoletosRequest
     * @return mixed|void
     * @throws \Exception
     */
    public function postBoleto(PostBoletosRequest $postBoletosRequest)
    {
        if (empty($this->auth['access_token'])) {
            throw new \Exception('Access Token is required');
        }

        try {
            $response = $this->post(EndPoint::Boleto, [
                'body' => (string) $postBoletosRequest->toJson(),
                'cert' => $this->config['cert'],
                'headers' => [
                    'x-itau-apikey' => $this->config['itauKey'],
                    'Authorization' => 'Bearer ' . $this->auth['access_token'],
                    'Content-Type' => 'application/json'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException | ServerException $e) {
            return json_decode((string) $e->getResponse()->getBody()->getContents(), true);
        }

    }

}
