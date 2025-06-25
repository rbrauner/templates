#!/usr/bin/env bash

docker compose up -d
docker exec -it template-node bash -c "yarn install"
docker exec -it template-node bash -c "yarn run build"

rsync -zariv --delete --mkpath -e 'ssh -p 22' dist/ user@host:/apps/template/dist
rsync -zariv --delete --mkpath -e 'ssh -p 22' docker/prod/ user@host:/apps/template/docker/prod
rsync -zariv --delete --mkpath -e 'ssh -p 22' compose.example-prod.yaml user@host:/apps/template/compose.yaml

ssh -t -p 22 user@host "chown -R rbrauner:apps /apps/template"

ssh -t -p 22 user@host "cd /apps/template && docker compose down"
ssh -t -p 22 user@host "cd /apps/template && docker compose up -d"
