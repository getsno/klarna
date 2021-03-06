<?php

namespace Gets\Klarna\Api;

class Config
{
    public $baseUrls = [
        'dev'  => 'https://api.playground.klarna.com/',
        'prod' => 'https://api.klarna.com/'
    ];

    public $baseUrl;
    public $user;
    public $password;

    public function __construct(string $user, string $password, string $mode = 'dev')
    {
        $this->user = $user;
        $this->password = $password;
        $this->baseUrl = $this->baseUrls[$mode];
    }
}