<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public array $default = [
        'allowedOrigins' => [
            'http://localhost:5173',
        ],
        'allowedOriginsPatterns' => [],
        'supportsCredentials'    => false,
        'allowedHeaders'         => [
            'Content-Type',
            'Authorization',
            'X-Requested-With',
            'Accept',
            'Origin',
        ],
        'exposedHeaders'  => [],
        'allowedMethods'  => [
            'GET',
            'POST',
            'PUT',
            'DELETE',
            'OPTIONS',
        ],
        'maxAge' => 7200,
    ];
}