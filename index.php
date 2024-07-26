<?php

// charge l'autoload de composer
require "vendor/autoload.php";

session_start();
if(!isset($_SESSION['csrf_token'])){
  $tm = new CSRFTokenManager();
  $tm->generateCSRFToken();
}
// charge le contenu du .env dans $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();

$router->handleRequest($_GET);