<?php

namespace Gets\Klarna\Api;

class Config
{
    public array $baseUrls = [
        'dev' => 'https://api.playground.klarna.com/',
        'prod' => 'https://api.klarna.com/'
    ];

    public string $baseUrl;

    public function __construct(public $user, public $password, $mode = 'dev')
    {
        $this->baseUrl = $this->baseUrls[$mode];
    }
}