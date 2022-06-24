FROM webdevops/php-nginx:7.4

RUN apt-get update && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Composer installation
WORKDIR /app
RUN curl -sS https://getcomposer.org/installer | php -- --check && \
    rm -rf vendor && \
    export COMPOSER_MEMORY_LIMIT=-1

# Folder permissions
RUN chown application:application /app -R
