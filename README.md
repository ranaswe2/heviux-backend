## Introduction To Heviux

Heviux is a start-up brand for fashion businesses based in France. This software project aims to manage the overall Heviux system. The front-end part of the project is developed by another team. This system produces 50+ RESTful APIs to connect the front end. I used Postman to test the API. You have found the API List (tested from Postman) in "heviux-backend/postman_api_collection" path. 

## Settings

Before running this system, define '.env' file correctly, install composer and vite. I suggested you to define the '.env' file as:

APP_NAME=Laravel </br>
APP_ENV=local </br>
APP_KEY= <> </br>
APP_DEBUG=true </br>
APP_URL=http://localhost </br>

LOG_CHANNEL=stack </br>
LOG_DEPRECATIONS_CHANNEL=null </br>
LOG_LEVEL=debug </br>

DB_CONNECTION=mysql </br>
DB_HOST=127.0.0.1 </br>
DB_PORT=3306 </br>
DB_DATABASE=<DB Name> </br>
DB_USERNAME=<> </br>
DB_PASSWORD=<> </br>

BROADCAST_DRIVER=log </br>
CACHE_DRIVER=file </br>
FILESYSTEM_DISK=local </br>
QUEUE_CONNECTION=sync </br>
SESSION_DRIVER=file </br>
SESSION_LIFETIME=120 </br>

MEMCACHED_HOST=127.0.0.1 </br>

REDIS_HOST=127.0.0.1 </br>
REDIS_PASSWORD=null </br>
REDIS_PORT=6379 </br>

MAIL_MAILER=smtp </br>
MAIL_HOST=smtp.gmail.com </br>
MAIL_PORT=587 </br>
MAIL_USERNAME=example@gmail.com </br>
MAIL_PASSWORD=<password> </br>
MAIL_ENCRYPTION=tls </br>
MAIL_FROM_ADDRESS="example@gmail.com" </br>
MAIL_FROM_NAME="Heviux" </br>
MAIL_DEBUG=true </br>

AWS_ACCESS_KEY_ID= </br>
AWS_SECRET_ACCESS_KEY= </br>
AWS_DEFAULT_REGION=us-east-1 </br>
AWS_BUCKET= </br>
AWS_USE_PATH_STYLE_ENDPOINT=false </br>

PUSHER_APP_ID= </br>
PUSHER_APP_KEY= </br>
PUSHER_APP_SECRET= </br>
PUSHER_HOST= </br>
PUSHER_PORT=443 </br>
PUSHER_SCHEME=https </br>
PUSHER_APP_CLUSTER=mt1 </br>

VITE_APP_NAME="${APP_NAME}" </br>
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}" </br>
VITE_PUSHER_HOST="${PUSHER_HOST}" </br>
VITE_PUSHER_PORT="${PUSHER_PORT}" </br>
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}" </br>
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}" </br>

#PayPal API Mode </br>
# Values: sandbox or live (Default: live) </br>
PAYPAL_MODE=sandbox </br>

#PayPal Setting & API Credentials - sandbox </br>
PAYPAL_SANDBOX_CLIENT_ID=<set id> </br>
PAYPAL_SANDBOX_CLIENT_SECRET=<set secret key> </br>

#PayPal Setting & API Credentials - live </br>
#PAYPAL_LIVE_CLIENT_ID= </br>
#PAYPAL_LIVE_CLIENT_SECRET= </br>

## Database

As the DB contains some sensitive data, you have to create new DB and migrate the models for testing the application.

