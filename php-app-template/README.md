# PHP App Template

## General

### Tools versions

- PHP ^8.3
- PHP extensions (install all to satisfy `symfony check:requirements`)
- Composer ^2

## Dev

### Requirements

- Docker

### Getting started

1. Clone repository: `git clone git@github.com:rbrauner/template.git`
2. Enter project folder: `cd template`
3. Copy `.env.example-dev` to `.env`: `cp .env.example-dev .env`
4. Set variables in `.env`
5. Copy `compose.example-dev.yaml` to `compose.yaml`: `cp compose.example-dev.yaml compose.yaml`
6. Update `compose.yaml` (optional)
7. Create `main` network: `docker network create --driver=bridge --subnet=10.0.0.0/8 --gateway=10.0.0.1 main`
8. Run external database or add to `compose.yaml`, e.x.:

```yaml
services:
    postgres:
        image: postgres:alpine
        container_name: template-postgres
        restart: unless-stopped
        environment:
            POSTGRES_USER: "default"
            POSTGRES_PASSWORD: "secret"
            POSTGRES_DB: "default"
        # ports:
        #     - 5432:5432
        networks:
            main:
        volumes:
            - postgres:/var/lib/postgresql/data

networks:
    main:
        external: true

volumes:
    postgres:
```

9. Build docker containers: `docker compose up -d --build`
10. Install php dependencies: `docker exec -it template-php bash -c "composer install"`

### Run

```bash
docker compose start
```

App will be available on [http://template.local](http://template.local) (remember to configure reverse proxy).

At the end of the work run:

```shell
docker compose stop
```

### Usefull commands

- `docker compose start` - start containers
- `docker compose stop` - start containers
- `docker exec -it template-php bash -c "composer install"` - install php dependencies
- `docker exec -it template-php bash -c "composer update"` - update php dependencies
- `docker exec -it template-php bash -c "composer run check"` - check code
- `docker exec -it template-php bash -c "composer run fix"` - fix code
- `docker exec -it template-php bash -c "composer run test"` - run tests
- `docker exec -it template-php bash -c "composer run rector"` - run rector
- `docker exec -it template-php bash -c "composer run check-security"` - check security
- `docker exec -it template-php bash -c "composer run normalize-composer"` - normalize composer.json

## Prod

### Requirements

- Docker
- Rsync

### Getting started

1. Prepare like on dev
2. Prepare server (only once):
   1. Create folders on server: `ssh -t -p 22 user@host "mkdir -p /apps/template"`
   2. Create database in `postgres` container
   3. Upload .env file: `rsync -zariv --delete --mkpath -e 'ssh -p 22' .env.example-prod user@host:/apps/template/.env`
   4. Update .env file: `ssh -t -p 22 user@host "vim /apps/template/.env"`

### Deploy

1. Run deploy script: `./bin/deploy.sh`
