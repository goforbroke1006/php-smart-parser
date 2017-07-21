<?php

namespace SmartParserApp\Grabber;

use SmartParserApp\Grabber;
use SmartParserApp\Smart;

class UnizooRu implements Grabber
{
    /**
     * @param string $url
     * @return boolean
     */
    public function supports($url)
    {
        return false !== strpos($url, '://unizoo.ru');
    }

    /**
     * @param Smart $smart
     * @param string $url
     * @return mixed
     */
    public function execute(Smart $smart, $url)
    {
        $smart->amOnPage($url);

        $priceChoices = $smart->getElementsBy('.list.md_choice.colorChoice[id="Вес"] > li > a[data-id]', null, 'кг');

        print $url . PHP_EOL;

        foreach ($priceChoices as $choice) {
            $choice->click();
            $smart->getDriver()->wait(3);

            $pricesEls = $smart->getElementsBy('#zPrice > span');
            if (0 < count($pricesEls)) {
                print '  ' . $pricesEls[0]->getText() . PHP_EOL;
            }
        }

        return true;
    }
}