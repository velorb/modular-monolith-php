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

ssh-redis:
	docker compose --env-file docker.env exec -u root redis bash

test:
	@echo "$(GREEN)🛠️ [1/4] static analysis - phpstan$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'vendor/bin/phpstan analyse --configuration=phpstan.dist.neon'

	@echo "$(GREEN)🛠️ [2/4] static analysis - phpcsfixer$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'tools/vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --verbose --show-progress=dots --diff'

	@echo "$(GREEN)🛠️ [3/4] unit tests$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'vendor/bin/phpunit --testsuite unit --colors=always'

	@echo "$(GREEN)🛠️ [4/4] integration tests$(NC)"
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console doctrine:cache:clear-m --env=test'
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console cache:clear --env=test'
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'APP_RESET_DATABASE=1 vendor/bin/phpunit --testsuite integration --colors=always'

swagger-validate:
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'npx swagger-cli validate docs/openapi/index.yaml'

swagger-build:
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'npx swagger-cli bundle docs/openapi/index.yaml -o public/openapi.json -t json'

run-migrations:
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console doctrine:migrations:migrate --no-interaction'

migration:
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console doctrine:cache:clear-m'
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console cache:clear'
	docker compose --env-file docker.env exec -u www-data php-fpm bash -c 'bin/console make:migration --no-interaction'

xdebug-enable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-enable'

xdebug-disable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-disable'
