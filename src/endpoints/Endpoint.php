<?php

namespace GlueAgency\IPStack\endpoints;

use GlueAgency\IPStack\IpStack;
use GuzzleHttp\Client;

class Endpoint
{

    CONST URI = 'http://api.ipstack.com/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = IpStack::$plugin->getSettings()->apiKey;
        $this->client = new Client([
            'base_uri' => self::URI,
            'query'    => [
                'access_key' => $this->apiKey,
            ],
        ]);
    }

    public function standard(string $ip)
    {
        $response = $this->client->get($ip);

        return $response->getBody()->getContents();
    }
}
