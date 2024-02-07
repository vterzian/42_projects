.PHONY: all build install fixtures run logs test stop clean re

all:

build:
	docker-compose build

install: run
	docker-compose exec php composer install

fixtures:
	docker-compose exec mysql mysql matcha < docker/mysql/fixtures.sql

run:
	chmod 777 public/img/user
	docker-compose up -d

logs:
	docker-compose logs --follow

test:
	docker-compose exec php vendor/bin/phpunit

stop:
	docker-compose kill

clean: stop
	docker-compose rm -f

re: clean build install
