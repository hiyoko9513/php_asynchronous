<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Pool;
use GuzzleHttp\Client;

$client = new Client();

$requests = static function () use ($client) {
    for ($i = 0; $i < 10; $i++) {
        yield static function() use ($client, $i) {
            return $client->requestAsync('GET', "{$_SERVER['SERVER_ADDR']}:80/wait.php?request_id=$i");
        };
    }
};

$pool = new Pool($client, $requests(), [
    'concurrency' => 10,
    'fulfilled' => static function ($response, $index) use (&$contents) {
        $contents[$index] = [
            'status_code'      => $response->getStatusCode(),
            'body'             => $response->getBody()->getContents(),
        ];
    },
    'rejected' => static function ($reason, $index) use (&$contents) {
        $contents[$index] = [
            'reason' => $reason
        ];
    },
]);

$promise = $pool->promise();
$promise->wait();

var_dump($contents);
