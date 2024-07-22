FROM node:21.2.0 as frontend

WORKDIR /app
COPY . .

RUN npm install
RUN npm run build

FROM php:8.2.20

# Install needed PHP extensions
RUN apt-get update -y && apt-get install libzip-dev libpng-dev libpq-dev -y
RUN docker-php-ext-install zip gd pdo_pgsql

# Install composer
RUN \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"  && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

WORKDIR app
COPY . .

COPY --from=frontend /app/public /app/public

# Install the backend application
RUN composer install

RUN echo "APP_ENV=production" >> .env
RUN echo "APP_DEBUG=true" >> .env
RUN echo "APP_KEY=" >> .env
RUN echo "SANCTUM_STATEFUL_DOMAINS=127.0.0.1,localhost,127.0.0.1:8000,127.0.0.1:5173" >> .env
RUN echo "SESSION_DRIVER=cookie" >> .env
RUN echo "SESSION_DOMAIN=127.0.0.1" >> .env
RUN echo "DB_CONNECTION=pgsql" >> .env

RUN php artisan key:generate

ENV PORT=8000
EXPOSE ${PORT}

CMD \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
