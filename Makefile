start:
	docker compose --env-file docker.env up -d

stop:
	docker compose --env-file docker.env stop

build-php:
	docker compose --env-file docker.env --progress=plain build php-fpm

ssh:
	docker compose --env-file docker.env exec -u www-data php-fpm bash

xdebug-enable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-enable'

xdebug-disable:
	docker compose --env-file docker.env exec -u root php-fpm bash -c 'xdebug-disable'
