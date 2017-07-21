#!/usr/bin/env bash

curl -o composer.phar https://getcomposer.org/composer.phar
php composer.phar install

curl -o selenium-server-standalone.jar http://selenium-release.storage.googleapis.com/2.53/selenium-server-standalone-2.53.1.jar

if [ "$(uname)" == "Darwin" ]; then
    CHROME_DRIVER_RES="https://chromedriver.storage.googleapis.com/2.30/chromedriver_mac64.zip"
elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
    CHROME_DRIVER_RES="https://chromedriver.storage.googleapis.com/2.30/chromedriver_linux64.zip"
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]; then
    CHROME_DRIVER_RES="https://chromedriver.storage.googleapis.com/2.30/chromedriver_win32.zip"
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW64_NT" ]; then
    CHROME_DRIVER_RES="https://chromedriver.storage.googleapis.com/2.30/chromedriver_win32.zip"
fi
curl -o chromedriver.zip "${CHROME_DRIVER_RES}"
unzip -o chromedriver.zip && rm -f chromedriver.zip