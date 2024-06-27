<?php

require_once __DIR__ . '/commands/MigrateCommand.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/model/Database.php';

$pdo = new PDO(
    "mysql:host=" . $config['db']['host'] . ";dbname=" . $config['db']['name'],
    $config['db']['user'],
    $config['db']['password']
);
$command = new MigrateCommand($pdo, 'database/migrations', 'migrations');
$command->handle();
