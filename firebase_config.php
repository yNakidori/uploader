<?php
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;

$firebaseConfigPath = __DIR__ . '/phpdb.json';

if (!file_exists($firebaseConfigPath)) {
    die('Arquivo de configuração do Firebase não encontrado: ' . $firebaseConfigPath);
}

$factory = (new Factory)->withServiceAccount($firebaseConfigPath)->withDatabaseUri('https://php-uploader-9943d-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
