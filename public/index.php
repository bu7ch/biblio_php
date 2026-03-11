<?php
// TODO: ajotuer le namespace + psr4 dans le composer.json
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/../vendor/autoload.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');



