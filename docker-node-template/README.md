# Docker Node Template

## General

### Tools versions

- Node ^22.16
- Yarn ^1

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
8. Build docker containers: `docker compose up -d --build`
9. Install node dependencies: `docker exec -it template-node bash -c "yarn install"`

### Run

```bash
docker compose start
```

App will be available on [http://template.localhost](http://template.localhost) (remember to configure reverse proxy).

At the end of the work run:

```shell
docker compose stop
```

### Usefull commands

- `docker compose start` - start containers
- `docker compose stop` - start containers
- `docker exec -it template-node bash -c "yarn install"` - install node dependencies
- `docker exec -it template-node bash -c "yarn upgrade"` - update node dependencies
- `docker exec -it template-node bash -c "yarn run check"` - node check
- `docker exec -it template-node bash -c "yarn run fix"` - node fix

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
