FROM node:lts-alpine AS packages
RUN apk update
RUN apk upgrade
RUN apk add bash tzdata git vim findutils curl
RUN apk cache clean

FROM packages AS environments
# args and envs
ARG TZ="Europe/Warsaw"
ARG USER="app"
ARG GROUP="app"
ARG UID=1000
ARG GID=1000
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

FROM configs AS base

FROM base as dev
COPY ./docker/node/dev/startup.sh /usr/local/bin/startup.sh
RUN chown -R $UID:$GID /usr/local/bin/startup.sh
USER $UID:$GID
CMD ["/usr/local/bin/startup.sh"]

FROM base as prod
COPY ./docker/node/prod/startup.sh /usr/local/bin/startup.sh
RUN chown -R $UID:$GID /usr/local/bin/startup.sh
USER $UID:$GID
CMD ["/usr/local/bin/startup.sh"]
