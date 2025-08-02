<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$connection = mysqli_connect(
  $_ENV["DB_HOST"],
  $_ENV["DB_USER"],
  $_ENV["DB_PASS"],
  $_ENV["DB_NAME"]
);
