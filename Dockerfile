# syntax=docker/dockerfile:1
#
# Production image for the Plafond site (Laravel 13 + Vite/Tailwind).
# Coolify builds it from the GitHub repo; nginx + php-fpm serve it on port 8080.
# No database: sessions, cache and the PDF rate limit live on files inside the container.

# ---------- 1) Front-end assets (Vite 8 needs Node 20.19+) ----------
FROM node:22-alpine AS assets
WORKDIR /app
# Full context so Tailwind can scan the Blade templates for the classes they use.
COPY . .
RUN npm ci && npm run build

# ---------- 2) PHP dependencies (no dev packages) ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction --optimize-autoloader

# ---------- 3) Runtime: nginx + php-fpm ----------
FROM serversideup/php:8.4-fpm-nginx

# Defaults for a single container without a database; Coolify's env vars override them.
# AUTORUN caches config/routes/views on start; there are no migrations to run.
ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    SESSION_DRIVER=file \
    CACHE_STORE=file \
    QUEUE_CONNECTION=sync \
    PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION=false

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .
COPY --from=vendor --chown=www-data:www-data /app/vendor ./vendor
COPY --from=assets --chown=www-data:www-data /app/public/build ./public/build

# Package discovery (skipped in the composer stage) and writable dirs,
# including storage/fonts where dompdf caches the PDF font metrics.
RUN php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/fonts \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080
