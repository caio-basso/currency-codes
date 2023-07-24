<?php

namespace App\Integrator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PythonIntegrator
{
    private string $uri;
    private Client $client;

    public function __construct()
    {
        $pythonApiHost = config('services.python_api.host');
        $pythonApiPort = config('services.python_api.port');

        $this->uri = "{$pythonApiHost}:{$pythonApiPort}";
        $this->client = new Client([
            'base_uri' => $this->uri,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function runCrawler(): array
    {
        $response = $this->client->get('');

        return json_decode($response->getBody()->getContents(), true);
    }
}
