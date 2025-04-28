<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

new Dotenv()->bootEnv(dirname(__DIR__).'/.env');

if (isset($_ENV['APP_RESET_DATABASE']) && $_ENV['APP_RESET_DATABASE'] === '1') {
    passthru('php ' . __DIR__ . '/../bin/console doctrine:database:drop --force --if-exists --env=test');
    passthru('php ' . __DIR__ . '/../bin/console doctrine:database:create --env=test');
    passthru('php ' . __DIR__ . '/../bin/console doctrine:migrations:migrate --no-interaction --env=test');
}
if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}


