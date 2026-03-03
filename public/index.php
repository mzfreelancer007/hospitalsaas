<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
header('Content-Type: application/json');

if ($path === '/' || $path === '/health') {
    http_response_code(200);
    echo json_encode([
        'status' => 'ok',
        'service' => 'hospitalsaas',
        'version' => trim(@file_get_contents(__DIR__ . '/../VERSION')),
    ], JSON_PRETTY_PRINT);
    return;
}

if ($path === '/api/v1') {
    http_response_code(200);
    echo json_encode([
        'message' => 'HMS scaffold API',
        'routes' => [
            'POST /api/v1/onboarding/hospitals',
            'POST /api/v1/auth/login',
            'POST /api/v1/auth/logout',
            'GET /api/v1/users',
            'GET /api/v1/patients',
            'GET /api/v1/departments',
            'GET /api/v1/doctors',
            'GET /api/v1/appointments',
        ],
    ], JSON_PRETTY_PRINT);
    return;
}

http_response_code(404);
echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
