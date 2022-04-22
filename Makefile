include makefiles/help.mk

composer: ##@development running your composer commands with arguments (e.g. make composer install)
	docker-compose exec -T php composer $(filter-out $@,$(MAKECMDGOALS))
.PHONY: composer

cli: ##@development
	docker-compose exec php bash
.PHONY: cli

setup: ##@setup install dependencies
	make install-git-hooks
	docker-compose up -d
	docker-compose exec -T php composer install
	docker-compose exec -T php vendor/bin/codecept build
.PHONY: setup

start: ##@setup install dependencies
	docker-compose up -d
.PHONY: start

stop: ##@setup install dependencies
	docker-compose stop -t 1
.PHONY: stop

tests: ##@development run tests
	docker-compose exec -T php vendor/bin/codecept run
.PHONY: tests

test-coverage: ##@development run tests
	docker-compose exec -T php vendor/bin/phpunit --colors=always -c phpunit.xml --coverage-text --coverage-html=tests/_output
.PHONY: test-coverage

phpstan: ##@development run phpstan
	docker-compose exec -T php vendor/bin/phpstan analyse
.PHONY: phpstan

sniff-project: ##@development run code sniffer
	docker-compose exec -T php vendor/bin/phpcs src/ tests/ --standard=./config/codesniffer_ruleset.xml
.PHONY: sniff-project

sniff-fix-project: ##@development run code sniffer
	docker-compose exec -T php vendor/bin/phpcbf src/ tests/ --standard=./config/codesniffer_ruleset.xml
.PHONY: sniff-fix-project

install-git-hooks: ##@development install git hooks
	git config core.hooksPath .githooks
	@if [ ${UNAME} = "Darwin" ]; then cp -f .githooks/* .git/hooks; else cp -f -l .githooks/* .git/hooks; fi
.PHONY: install-git-hooks
