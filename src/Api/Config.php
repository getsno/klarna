<?php

namespace Gets\Klarna\Api;

class Config
{
    public $baseUrls = [
        'dev'  => 'https://api.playground.klarna.com/',
        'prod' => 'https://api.klarna.com/'
    ];

    public string $baseUrl;
    public string $user;
    public string $password;

    public function __construct(string $user, string $password, $mode = 'dev')
    {
        $this->user = $user;
        $this->password = $password;
        $this->baseUrl = $this->baseUrls[$mode];
    }
}