<?php

namespace Gets\Klarna\Api;

class Config
{
    public array $baseUrls = [
        'test' => 'https://api.playground.klarna.com/',
        'live' => 'https://api.klarna.com/'
    ];

    public string $baseUrl;

    public function __construct(public $user, public $password, $mode = 'test')
    {
        $this->baseUrl = $this->baseUrls[$mode];
    }
}