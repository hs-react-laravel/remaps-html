<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PleskService
{
    protected $client;
    protected $apiKey;
    protected $base_url;
    protected $targetIp;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('plesk.base_url'), // https://your-plesk-server:8443/
            'verify' => false,
        ]);

        $this->apiKey = config('plesk.api_key');
        $this->base_url = config('plesk.base_url');
        $this->targetIp = config('plesk.target_ip');
    }

    /**
     * get access token from plesk
     * plesk bin secret_key -c -ip-address 192.200.115.226 -description "Admin access token"
     * curl -kLi -H "Content-Type: text/xml" -H "KEY: xxxx-xxxx" -H "HTTP_PRETTY_PRINT: TRUE"  -d "@D:\\api.rpc" https://apthosting.uk:8443/enterprise/control/agent.php
     * 
     * 
     */
    // https://support.plesk.com/hc/en-us/articles/12377451966359-How-to-create-a-domain-subdomain-alias-in-Plesk
    public function addDomain($domain): string
    {
      $client = new Client();

    $xml = <<<XML
<packet>
  <site>
    <add>
      <gen_setup>
        <name>{$domain}</name>
        <webspace-id>45</webspace-id>
      </gen_setup>
      <hosting>
        <vrt_hst>
          <property>
            <name>www_root</name>
            <value>apt.remapdash.com/public</value>
          </property>
        </vrt_hst>
      </hosting>
    </add>
  </site>
</packet>
XML;

  Log::info('plesk.base_url: '.$this->base_url); 
  Log::info('plesk.api_key: '.$this->apiKey);
  Log::info('plesk.target_ip: '.$this->targetIp);
  Log::info('domain: '.$domain);
  
    $response = $client->post($this->base_url . '/enterprise/control/agent.php', [
        'headers' => [
            'Content-Type' => 'text/xml',
            'KEY' => $this->apiKey,
        ],
        'body' => $xml,
        'verify' => false, 
    ]);

    $xmlResponse = $response->getBody()->getContents();
    Log::info('response: '.$xmlResponse);
    return $xmlResponse;
    }
}
