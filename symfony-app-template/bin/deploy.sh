#!/usr/bin/env bash

docker compose up -d
docker exec -it template-php bash -c "APP_ENV=prod composer.phar install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader"

rsync -zariv --delete --mkpath -e 'ssh -p 22' bin/console user@host:/apps/template/bin/console
rsync -zariv --delete --mkpath -e 'ssh -p 22' config/ user@host:/apps/template/config
rsync -zariv --delete --mkpath -e 'ssh -p 22' data/ user@host:/apps/template/data
rsync -zariv --delete --mkpath -e 'ssh -p 22' docker/prod/ user@host:/apps/template/docker/prod
rsync -zariv --delete --mkpath -e 'ssh -p 22' migrations/ user@host:/apps/template/migrations
rsync -zariv --delete --mkpath -e 'ssh -p 22' public/ user@host:/apps/template/public
rsync -zariv --delete --mkpath -e 'ssh -p 22' src/ user@host:/apps/template/src
rsync -zariv --delete --mkpath -e 'ssh -p 22' templates/ user@host:/apps/template/templates
rsync -zariv --delete --mkpath -e 'ssh -p 22' translations/ user@host:/apps/template/translations
rsync -zariv --delete --mkpath -e 'ssh -p 22' vendor/ user@host:/apps/template/vendor
rsync -zariv --delete --mkpath -e 'ssh -p 22' compose.example-prod.yaml user@host:/apps/template/compose.yaml
rsync -zariv --delete --mkpath -e 'ssh -p 22' composer.json user@host:/apps/template/composer.json
rsync -zariv --delete --mkpath -e 'ssh -p 22' composer.lock user@host:/apps/template/composer.lock
rsync -zariv --delete --mkpath -e 'ssh -p 22' symfony.lock user@host:/apps/template/symfony.lock

ssh -t -p 22 user@host "mkdir -p /apps/template/var"
ssh -t -p 22 user@host "rm -rf /apps/template/var/cache/*"
ssh -t -p 22 user@host "chown -R rbrauner:apps /apps/template"

ssh -t -p 22 user@host "cd /apps/template && docker compose down"
ssh -t -p 22 user@host "cd /apps/template && docker compose up -d"
ssh -t -p 22 user@host "cd /apps/template && docker exec -it template-php bash -c 'php bin/console cache:clear'"
ssh -t -p 22 user@host "cd /apps/template && docker exec -it template-php bash -c 'php bin/console doctrine:migrations:migrate --no-interaction'"
ssh -t -p 22 user@host "cd /apps/template && docker exec -it template-php bash -c 'php bin/console cache:clear'"
