<?php
$host = getenv('AUCTION_DB_HOST') ?: 'localhost';
$user = getenv('AUCTION_DB_USER') ?: 'auction_lab';
$password = getenv('AUCTION_DB_PASSWORD') ?: '';
$database = getenv('AUCTION_DB_NAME') ?: 'auction';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    http_response_code(500);
    exit('Database connection failed. Check the local environment variables.');
}

mysqli_set_charset($conn, 'utf8mb4');

