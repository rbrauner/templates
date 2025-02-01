#!/usr/bin/env bash

npm install
npm run build:app
npm run build:ssr
rm -rf node_modules
npm run ssr:serve
