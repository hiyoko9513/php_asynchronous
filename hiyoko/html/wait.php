<?php

 $request_id = $_GET['request_id'];

 sleep($request_id % 3);


sleep(5);

header("Access-Control-Allow-Origin: " . '*');
header("Content-Type: application/json; charset=utf-8");

try {
    echo json_encode([
        'status' => 'OK',
        'request_id' => $request_id,
    ], JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    echo 'status: NG';
}
