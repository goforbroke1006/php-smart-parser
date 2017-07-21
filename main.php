<?php

// https://docs.google.com/spreadsheets/d/1PdVfCRdEoOKuki_Kw3iwMjpgtjHpbHuHuaWNf1Yfm-Y/edit#gid=0
require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

$testUrls = [
    'https://unizoo.ru/catalog/52252/',
    'https://unizoo.ru/catalog/51407/',
    'https://unizoo.ru/catalog/51405/',
    'https://app.codeship.com/dashboard',
];

$driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome(), 5000);

try {
    $config = Yaml::parse(file_get_contents(__DIR__ . '/config.yml'))['smart-parser'];

    $smart = new \SmartParserApp\Smart($driver);

    foreach ($testUrls as $url) {
        foreach ($config['grabber_strategies'] as $grabberClassName) {
            /** @var \SmartParserApp\Grabber $grabber */
            $grabber = new $grabberClassName();
            if ($grabber->supports($url)) {
                $grabber->execute($smart, $url);
            }
        }
    }

    $driver->close();

} catch (ParseException $e) {
    printf('Parsing file "./config.yml" error: ' . $e->getMessage());
    exit(1);
} catch (\Exception $exception) {
    printf('You should setup config in "./config.yml"');
    exit(1);
}