## Introduction To Heviux

Heviux is a start-up brand for fashion businesses based in France. This software project aims to manage the overall Heviux system. The front-end part of the project is developed by another team. This system produces 50+ RESTful APIs to connect the front end. I used Postman to test the API. You have found the API List (tested from Postman) in "heviux-backend/postman_api_collection" path. 

## Settings

Before running this system, define '.env' file correctly, install composer and vite. I suggested you to define the '.env' file as:

APP_NAME=Laravel </br>
APP_ENV=local </br>
APP_KEY= <> </br>
APP_DEBUG=true </br>
APP_URL=http://localhost </br>

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DB Name>
DB_USERNAME=<>
DB_PASSWORD=<>

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=<password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="example@gmail.com"
MAIL_FROM_NAME="Heviux"
MAIL_DEBUG=true

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

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

#PayPal API Mode
# Values: sandbox or live (Default: live)
PAYPAL_MODE=sandbox

#PayPal Setting & API Credentials - sandbox
PAYPAL_SANDBOX_CLIENT_ID=<set id>
PAYPAL_SANDBOX_CLIENT_SECRET=<set secret key>

#PayPal Setting & API Credentials - live
#PAYPAL_LIVE_CLIENT_ID=
#PAYPAL_LIVE_CLIENT_SECRET=

## Database

As the DB contains some sensitive data, you have to create new DB and migrate the models for testing the application.

