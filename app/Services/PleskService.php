<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PleskService
{
    protected $client;
    protected $username;
    protected $password;
    protected $targetIp;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('plesk.base_url'), // https://your-plesk-server:8443/
            'verify' => false,
        ]);

        $this->username = config('plesk.username');
        $this->password = config('plesk.password');
        $this->targetIp = config('plesk.target_ip');

        Log::info('plesk.base_url: '.config('plesk.base_url')); 
        Log::info('plesk.username: '.config('plesk.username'));
        Log::info('plesk.password: '.config('plesk.password'));
        Log::info('plesk.target_ip: '.config('plesk.target_ip'));
    }

    public function addDomain(string $domain): string
    {
      $targetIp = $this->targetIp;
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet version="1.6.3.0">
  <webspace>
    <add>
      <gen_setup>
        <name>{$domain}</name>
        <ip_address>{$targetIp}</ip_address>
      </gen_setup>
      <hosting>
        <none/>
      </hosting>
    </add>
  </webspace>
</packet>
XML;

        $response = $this->client->post('enterprise/control/agent.php', [
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'auth' => [$this->username, $this->password],
            'body' => $xml,
        ]);

        return $response->getBody()->getContents();
    }
}
