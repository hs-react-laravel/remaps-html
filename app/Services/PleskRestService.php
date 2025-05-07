<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;
class PleskRestService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('plesk.base_url'), 
            'verify' => false,
        ]);
    }

    public function addDomain1(string $domain, string $ip): array
    {
        try {
            $response = $this->client->post('domains', [
                'auth' => [config('plesk.username'), config('plesk.password')],
                'json' => [
                    'name' => $domain,
                    'hosting_type' => 'virtual',
                    'base_domain' => [
                      'name' => 'remapdash.com'
                    ],
                    'hosting_settings' => [
                      'ftp_login' => 'test_login',
                      'ftp_password' => '!@#QWE123qwe3~Gr5'
                    ],
                    'ipv4' => [$ip],
                ],
            ]);

            return json_decode($response->getBody(), true);
          } catch (\GuzzleHttp\Exception\ClientException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            Log::error('Plesk error', ['message' => $e->getMessage(), 'body' => $body]);
            return ['error' => $body];
        }
    }

    public function addDomain(string $domain, string $ip)
    {
        try {
          $response = Http::withBasicAuth(config('plesk.username'), config('plesk.password'))
          ->baseUrl(config('plesk.base_url'))
          ->withHeaders([
              'Content-Type' => 'application/json',
          ])
          ->withOptions([
              'verify' => false 
          ])
          ->post('/cli/domain/call', [
              'params' => [
                  '--create',
                  $domain,
                  '-ip',
                  $ip,
                  '-hosting',
                  '-www-root',
                  '%plesk_vhosts%remapdash.com/apt.remapdash.com/public'
              ]
          ]);
          if ($response->successful()) {
            Log::info("result_response");
            Log::info($response->json());
          } else {
            Log::error('Plesk error', ['message' => $response->status(), 'body' => $response->body()]);
          }
      
        } catch (Exception $e) {
          Log::error('Plesk error', ['message' => $e->getMessage()]);
          return ['error' => $e->getMessage()];
        }
    }
}
