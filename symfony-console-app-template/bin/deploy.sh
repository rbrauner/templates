#!/usr/bin/env bash

docker compose up -d
docker exec -it template-php bash -c "APP_ENV=prod composer.phar install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader"

rsync -zariv --delete --mkpath -e 'ssh -p 22' bin/template user@host:/apps/template/bin/template
rsync -zariv --delete --mkpath -e 'ssh -p 22' docker/prod/ user@host:/apps/template/docker/prod
rsync -zariv --delete --mkpath -e 'ssh -p 22' src/ user@host:/apps/template/src
rsync -zariv --delete --mkpath -e 'ssh -p 22' vendor/ user@host:/apps/template/vendor
rsync -zariv --delete --mkpath -e 'ssh -p 22' compose.example-prod.yaml user@host:/apps/template/compose.yaml
rsync -zariv --delete --mkpath -e 'ssh -p 22' composer.json user@host:/apps/template/composer.json
rsync -zariv --delete --mkpath -e 'ssh -p 22' composer.lock user@host:/apps/template/composer.lock

ssh -t -p 22 user@host "chown -R rbrauner:apps /apps/template"

ssh -t -p 22 user@host "cd /apps/template && docker compose down"
ssh -t -p 22 user@host "cd /apps/template && docker compose up -d"
