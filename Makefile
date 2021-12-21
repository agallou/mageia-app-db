.PHONY: \
	vendors \
	data_dirs \
	init

.DEFAULT: vendors

CURRENT_UID=$(shell id -u)
CURRENT_GID=$(shell id -g)

init: config
	docker-compose run --rm cli /bin/bash -l -c "make vendors"
	docker-compose run --rm cli /bin/bash -l -c "./symfony  propel:build-all --no-confirmation"
	docker-compose run --rm cli /bin/bash -l -c "./symfony  madb:insert-test-data"

# vendors
vendors: vendor

composer.phar:
	$(eval EXPECTED_SIGNATURE = "$(shell wget -q -O - https://composer.github.io/installer.sig)")
	$(eval ACTUAL_SIGNATURE = "$(shell php -r "copy('https://getcomposer.org/installer', 'composer-setup.php'); echo hash_file('SHA384', 'composer-setup.php');")")
	@if [ "$(EXPECTED_SIGNATURE)" != "$(ACTUAL_SIGNATURE)" ]; then echo "Invalid signature"; exit 1; fi
	php composer-setup.php
	rm composer-setup.php

vendor: composer.phar
	php composer.phar install

# docker
docker-up: log/docker-build data_dirs
	docker-compose up

docker-build: log/docker-build

log/docker-build: data_dirs docker-compose.yml docker-compose.override.yml $(shell find docker/dockerfiles -type f)
	docker-compose rm --force
	CURRENT_UID=$(CURRENT_UID) CURRENT_GID=$(CURRENT_GID) docker-compose build
	touch .docker-build

data_dirs: docker/data docker/data/composer

docker/data:
	mkdir -p docker/data

docker/data/composer: docker/data
	mkdir -p docker/data/composer

docker-compose.override.yml:
	cp docker-compose.override.yml-dist docker-compose.override.yml

config: config/databases.yml config/propel.ini config/madbconf.yml

config/databases.yml:
	cp config/databases.yml-dist config/databases.yml
	sed --in-place 's/%%host%%/dbapp/' config/databases.yml
	sed --in-place 's/%%database%%/madb/' config/databases.yml
	sed --in-place 's/%%user%%/madbuser/' config/databases.yml
	sed --in-place 's/%%pass%%/madbpass/' config/databases.yml

config/propel.ini:
	cp config/propel.ini-dist config/propel.ini
	sed --in-place 's/%%host%%/dbapp/' config/propel.ini
	sed --in-place 's/%%database%%/madb/' config/propel.ini
	sed --in-place 's/%%user%%/madbuser/' config/propel.ini
	sed --in-place 's/%%pass%%/madbpass/' config/propel.ini

config/madbconf.yml:
	cp config/madbconf.yml-dist config/madbconf.yml

