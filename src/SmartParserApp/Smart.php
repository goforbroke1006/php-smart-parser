<?php

namespace SmartParserApp;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class Smart
{
    /** @var RemoteWebDriver */
    private $driver;

    /**
     * @param RemoteWebDriver $driver
     */
    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $uri
     */
    public function amOnPage($uri)
    {
//        $this->driver->get($this->baseUrl . $uri);
        $this->driver->get($uri);
    }

    /**
     * @param string $selector
     * @param null|\Facebook\WebDriver\Remote\RemoteWebElement $parent
     * @param null $text
     * @return \Facebook\WebDriver\Remote\RemoteWebElement[]
     */
    public function getElementsBy($selector, $parent = null, $text = null)
    {
        $by = WebDriverBy::cssSelector($selector);
        if (null == $parent) {
            $elements = $this->driver->findElements($by);
        } else {
            $elements = $parent->findElements($by);
        }
        if (!empty($text)) {
            foreach ($elements as $key => $val) {
                if (false === strpos($val->getText(), $text)) {
                    unset($elements[$key]);
                }
            }
            $elements = array_values($elements);
        }
        return $elements;
    }

    /**
     * @return RemoteWebDriver
     */
    public function getDriver()
    {
        return $this->driver;
    }
}