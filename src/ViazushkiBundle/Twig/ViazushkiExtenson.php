<?php

namespace ViazushkiBundle\Twig;


class ViazushkiExtenson extends \Twig_Extension
{
    public function getFilters()
    {
        return [
          new \Twig_SimpleFilter('header', [$this, 'headerFilter']),
        ];
    }

    public function headerFilter($string, $size = 3)
    {
        if($size < 1 || $size > 6) $size = 3;
        $string = '<h'.$size.'>'.$string.'</h'.$size.'>';

        return $string;
    }
}
