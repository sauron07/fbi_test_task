#!/usr/bin/env bash

OAUTH_SERVER_ADDRESS=$1
if [ -z ${OAUTH_SERVER_ADDRESS} ]
then
    OAUTH_SERVER_ADDRESS="127.0.0.1:8001"
fi

SERVER_ADDRESS=$2
if [ -z ${SERVER_ADDRESS} ]
then
    SERVER_ADDRESS="127.0.0.1:8000"
fi


if [ ! -f ./composer.phar ]
then
    # Install composer
    echo "Installing composer locally."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" >> /dev/null
    echo "Setup composer:"
    php composer-setup.php >> /dev/null
    echo "Remove composer setup:"
    php -r "unlink('composer-setup.php');" >> /dev/null
fi

echo "Installing composer dependencies."
php ./composer.phar install

echo "Removing database if it exists."
./bin/console doctrine:database:drop --force --quiet
echo "Creating database."
./bin/console doctrine:database:create --quiet
echo "Updating schema."
./bin/console doctrine:schema:update --force --quiet
echo "Loading fixtures."
./bin/console doctrine:fixtures:load --no-interaction --quiet

echo "Starting web server on address ${SERVER_ADDRESS}"
./bin/console server:start ${SERVER_ADDRESS} --force --quiet

echo "    app.oauth_address: ${OAUTH_SERVER_ADDRESS}" >> ./app/config/parameters.yml
echo "Starting oAuth web server on address ${OAUTH_SERVER_ADDRESS}"
./bin/console server:start ${OAUTH_SERVER_ADDRESS} --force --quiet

echo "Application is up and running."