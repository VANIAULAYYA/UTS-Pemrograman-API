<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'success' => true,
    'data' => [
        'total_endpoints' => 12,
        'http_methods'    => 4,
        'total_resources' => 3,
        'methods_used'    => ['GET', 'POST', 'PUT', 'DELETE'],
        'resources'       => ['patients', 'doctors', 'appointments']
    ]
]);