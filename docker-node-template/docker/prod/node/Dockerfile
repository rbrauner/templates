FROM node:22.16-alpine

# args
ARG TZ="Europe/Warsaw"

# envs
ENV TZ=${TZ}

# packages
RUN apk update
RUN apk upgrade
RUN apk add bash tzdata git vim
RUN apk cache clean

# timezone and localtime
RUN echo $TZ > /etc/timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime

# make sure `/var/www/html` exists
RUN mkdir -p /var/www/html

# working directory
WORKDIR /var/www/html

# make `/var/www/html` safe for git operations
RUN git config --global --add safe.directory /var/www/html
