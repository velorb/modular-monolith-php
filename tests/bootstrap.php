<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

passthru('php ' . __DIR__ . '/../bin/console doctrine:database:drop --force --if-exists --env=test');
passthru('php ' . __DIR__ . '/../bin/console doctrine:database:create --env=test');
passthru('php ' . __DIR__ . '/../bin/console doctrine:migrations:migrate --no-interaction --env=test');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}


