<?php

namespace SmartParserApp;

interface Grabber
{
    /**
     * @param string $url
     * @return bool
     */
    public function supports($url);

    /**
     * @param Smart $smart
     * @param string $url
     * @return mixed
     */
    public function execute(Smart $smart, $url);
}