<?php

namespace App\Console\Commands;


use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;

class Client extends Command
{
    private $client;
    protected $signature = 'client {url} {string}';

    public function __construct()
    {
        parent::__construct();
        $this->client = new \GuzzleHttp\Client();
    }

    public function handle()
    {
        $url = $this->argument('url');
        $string = $this->argument('string');

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'string' => $string
                ]
            ]);
            $this->writeResult($response);
        } catch (RequestException $e) {
            $this->writeResult($e->getResponse());
        }

    }

    private function writeResult(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 200) {
            $body = json_decode($response->getBody());
            $this->line(sprintf('[%s] %s', $response->getStatusCode(), $body->message));
        } else {
            $this->warn('unknown response');
        }
    }
}