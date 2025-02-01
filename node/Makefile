.DEFAULT_GOAL := help

.PHONY: help init docker-lint docker-fix node-enter node-exec node-install node-update node-check node-fix node-run-dev node-run-build

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

# ===========
# = include =
# ===========
-include Makefile.local.mk
