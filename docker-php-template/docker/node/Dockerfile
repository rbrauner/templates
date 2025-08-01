FROM node:22.16-alpine AS base

FROM base AS packages
RUN apk update
RUN apk upgrade
RUN apk add bash tzdata git vim
RUN apk cache clean

FROM packages AS environments
# args and envs
ARG TZ="Europe/Warsaw"
ENV TZ=${TZ}

FROM environments AS configs
# working directory
WORKDIR /var/www/html
# timezone and localtime
RUN echo $TZ > /etc/timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime
# make sure `/var/www/html` exists
RUN mkdir -p /var/www/html
# make `/var/www/html` safe for git operations
RUN git config --global --add safe.directory /var/www/html
# create user and group for app
RUN addgroup -g 1000 -S app
RUN adduser -u 1000 -D -S -G app app

FROM configs AS dev
