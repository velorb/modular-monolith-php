GREEN=\033[0;32m
NC=\033[0m

start:
	docker compose --env-file docker.env up -d

stop:
	docker compose --env-file docker.env stop

build-php:
	docker compose --env-file docker.env --progress=plain build php-fpm

ssh:
	docker compose --env-file docker.env exec -u www-data php-fpm bash

test:
	@echo "$(GREEN)🛠️ [1/3] Statyczna analiza - PHPStan$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'vendor/bin/phpstan analyse --configuration=phpstan.dist.neon'

	@echo "$(GREEN)🛠️ [2/3] Testy jednostkowe (unit)$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'vendor/bin/phpunit --testsuite unit'

	@echo "$(GREEN)🛠️ [3/3] Testy integracyjne (integration)$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'APP_RESET_DATABASE=1 vendor/bin/phpunit --testsuite integration'

xdebug-enable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-enable'

xdebug-disable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-disable'
