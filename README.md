1. git clone <link:repository>
2. cd liramedika
3. download laradock di dalam repo -> git clone https://github.com/Laradock/laradock.git
4. cd laradock
5. cp .env.example .env
6. build laradock (perhatikan) . . . sebelum build, lakukan konfigurasi php-worker, .env, dan lain-lain.

+++++++++++.env+++++++++

APP_NAME="Lira Medika"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://liramedika.test

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=liramedika
DB_USERNAME=default
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=redis
REDIS_PASSWORD=secret_redis
REDIS_CLIENT=predis //pakai predis untuk horizon nantinya
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"


+++++++++++ php-worker +++++++++

cd /laradock/php-worker/supervisord.d
nano liramedika.conf


[program:laravel-horizon]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/artisan horizon
directory=/var/www
autostart=true
autorestart=true
numprocs=8
user=laradock
redirect_stderr=true
stdout_logfile=/var/www/storage/logs/horizon.log


+++++++++++ library +++++++++

1. breeze
2. horizon
3. predis
4. bootstrap
5. tailwind

+++++++++++ setup +++++++++

1. docker-compose exec --user=laradock workspace bash
2. migrate --seed
