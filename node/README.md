# Template

## General

### Tools versions

- Node LTS

## Dev

### Requirements

- Docker

### Getting started

1. Clone repository: `git clone git@github.com:rbrauner/template.git`
2. Enter project folder: `cd template`
3. Run init script and follow instructions `./bin/init`.

### Run

```bash
docker compose start
```

App will be available on [http://template.localhost](http://template.localhost) (remember to configure reverse proxy).

At the end of the work run:

```shell
docker compose stop
```

### Useful commands

See `Makefile`.

## Prod

### Requirements

- Docker
- Rsync

### Getting started

1. Prepare like on dev
2. Prepare server (only once):
   1. Create folders on server: `ssh -t -p 22 user@host "mkdir -p /apps/template"`
   2. Upload .env file: `rsync -zariv --delete --mkpath -e 'ssh -p 22' .env.example-prod user@host:/apps/template/.env`
   3. Update .env file: `ssh -t -p 22 user@host "vim /apps/template/.env"`

### Deploy

1. Run deploy script: `bin/deploy.sh`
