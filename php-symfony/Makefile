.DEFAULT_GOAL := help

.PHONY: help init docker-lint docker-fix php-enter php-exec php-install php-update php-composer-normalize php-clear php-clear-cache php-clear-logs php-check php-check-security php-fix php-test-all php-test-unit php-test-integration php-test-single php-doctrine-migrations-migrate php-doctrine-fixtures-load php-prepare-database php-messenger-setup-transports php-messenger-consume node-enter node-exec node-install node-update node-check node-fix node-run-dev node-run-build node-run-ssr-serve

# ========
# = vars =
# ========
OPTIONS :=
XDEBUG_TRIGGER := 0

# ================
# = common tasks =
# ================

# Show available targets
help:
	@awk '/^# / { c = substr($$0, 3); next } /^[a-z-]*:/ { split($$1, a, ":"); if (c) printf "  %-14s %s\n", a[1], c; c = "" }' $(MAKEFILE_LIST)

# Init environment (e.g. make init ENV=dev)
init:
	bin/init $(ENV)

# Docker lint
docker-lint:
	hadolint */**/Dockerfile
	prettier */**/{compose,compose.*}.yaml --check

# Docker fix
docker-fix:
	prettier */**/{compose,compose.*}.yaml --write

# =============
# = php tasks =
# =============

# Enter php container
php-enter:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash

# Execute command in php container (e.g. COMMAND="php -v")
php-exec:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "$(COMMAND) $(OPTIONS)"

# Install PHP dependencies
php-install:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "composer $(OPTIONS) install"

# Update PHP dependencies
php-update:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "composer $(OPTIONS) update"

# Normalize PHP composer.json and composer.lock
php-composer-normalize:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "composer $(OPTIONS) normalize"

# Clear PHP cache and logs
php-clear: php-clear-cache php-clear-logs

# Clear PHP cache
php-clear-cache:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/console $(OPTIONS) cache:clear && rm -rf var/cache/*"

# Clear PHP logs
php-clear-logs:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "rm -rf var/log/*"

# Check PHP
php-check:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "composer $(OPTIONS) normalize --dry-run"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "composer $(OPTIONS) audit"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/rector process --dry-run"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/php-cs-fixer check"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/phpstan analyse"
	@$(MAKE) php-check-security

# Check PHP security
php-check-security:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/security-checker security:check composer.lock"

# Fix PHP
php-fix:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/rector process"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 $(OPTIONS) vendor/bin/php-cs-fixer fix"

# Run all tests
php-test-all:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/phpunit $(OPTIONS) tests"

# Run unit tests
php-test-unit:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/phpunit $(OPTIONS) --testsuite unit"

# Run integration tests
php-test-integration:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/phpunit $(OPTIONS) --testsuite integration"

# Run single test (e.g. FILE="tests/AdminBundle/Services/PlatformImport/DynamicXmlTransformerTest.php --filter playroom")
php-test-single:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/phpunit $(OPTIONS) $(FILE)"

# Migrate database
php-doctrine-migrations-migrate:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:migrations:migrate --no-interaction"

# Load fixtures
php-doctrine-fixtures-load:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:fixtures:load --append --no-interaction"

# Prepare database for given environment
php-prepare-database:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "APP_ENV=$(ENV) php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:database:drop --force --if-exists"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "APP_ENV=$(ENV) php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:database:create"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "APP_ENV=$(ENV) php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:migrations:migrate --no-interaction"
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "APP_ENV=$(ENV) php -d memory_limit=-1 bin/console $(OPTIONS) doctrine:fixtures:load --append --no-interaction"

# Setup messenger transports
php-messenger-setup-transports:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/console $(OPTIONS) messenger:setup-transports"

# Consume messages from queue (e.g. QUEUE="queueOrders")
php-messenger-consume:
	docker compose exec -e XDEBUG_TRIGGER=$(XDEBUG_TRIGGER) -it php bash -c "php -d memory_limit=-1 bin/console $(OPTIONS) messenger:consume $(QUEUE)"

# ==============
# = node tasks =
# ==============

# Enter node container
node-enter:
	docker compose exec -it node bash

# Execute command in node container (e.g. COMMAND="node -v")
node-exec:
	docker compose exec -it node bash -c "$(COMMAND) $(OPTIONS)"

# Install node dependencies
node-install:
	docker compose exec -it node bash -c "npm $(OPTIONS) install"

# Update node dependencies
node-update:
	docker compose exec -it node bash -c "npm $(OPTIONS) upgrade"

# Check node
node-check:
	docker compose exec -it node bash -c 'npm $(OPTIONS) exec prettier --check "assets/**/*.{ts,vue,css,js,json}"'

# Fix node
node-fix:
	docker compose exec -it node bash -c 'npm $(OPTIONS) exec prettier --write "assets/**/*.{ts,vue,css,js,json}"'

# Run node in dev mode
node-run-dev:
	docker compose exec -it node bash -c "npm $(OPTIONS) run dev"

# Build node in production mode
node-run-build:
	docker compose exec -it node bash -c "npm $(OPTIONS) run build:app"
	docker compose exec -it node bash -c "npm $(OPTIONS) run build:ssr"

# Serve node SSR application
node-run-ssr-serve:
	docker compose exec -it node bash -c "npm $(OPTIONS) run ssr:serve"

# ===========
# = include =
# ===========
-include Makefile.local.mk
