
调整框架本身的配置

编辑.env

APP_ENV = production

APP_DEBUG = false

php artisan route:cache / php artisan config:cache

composer dump-autoload --optimize

php artisan optimize

其他可能

开启OPcache

php-fpm 配置调优