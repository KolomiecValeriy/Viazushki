<?php

namespace ViazushkiBundle\Twig;


use Symfony\Component\Filesystem\Filesystem;

class ViazushkiExtension extends \Twig_Extension
{
    private $env;
    private $filesystem;
    private $projectDir;

    public function __construct($env, Filesystem $filesystem, $projectDir)
    {
        $this->env = $env;
        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
    }

    public function getFilters()
    {
        return [
          new \Twig_SimpleFilter('header', [$this, 'headerFilter']),
          new \Twig_SimpleFilter('modifyDate', [$this, 'modifyDate']),
          new \Twig_SimpleFilter('httpToHttps', [$this, 'httpToHttps']),
          new \Twig_SimpleFilter('imageOrientation', [$this, 'imageOrientation']),
        ];
    }

    /**
     * @param string $image Full path to image
     *
     * @return string
     */
    public function imageOrientation($image)
    {
        $fs = $this->filesystem;
        $dir = $this->projectDir;
        if ($fs->exists($dir.'/web/'.$image)) {
            $imageSize = getimagesize($dir.'/web/'.$image);
            if ($imageSize[0] >= $imageSize[1]) {
                return 'horizontal';
            }

            return 'vertical';
        }

        return $image;
    }

    public function httpToHttps($url)
    {
        if ($this->env == 'dev') {
            return $url;
        }

        return preg_replace('/^http:\/\//i', 'https://', $url);
    }

    public function headerFilter($string, $size = 3)
    {
        if($size < 1 || $size > 6) {
            $size = 3;
        }
        $string = '<h'.$size.'>'.$string.'</h'.$size.'>';

        return $string;
    }

    /**
     * @param string $date
     * $date format must be "Y-m-d"
     * @param string $modifyString
     * $modifyString format must be "+|- count day"
     *
     * @return string $date
     */
    public function modifyDate($date, $modifyString)
    {
        if (!is_string($date) || !is_string($modifyString)) {
            throw new \InvalidArgumentException('Arguments is invalid.');
        }

        $modifyDate = explode('-', $date);
        $modifyString = explode(' ', $modifyString);

        if (count($modifyDate) != 3) {
            throw new \InvalidArgumentException('Date format is invalid.');
        }

        if (count($modifyString) != 3) {
            throw new \InvalidArgumentException('Modify string format is invalid.');
        }

        switch ($modifyString[0]) {
            case '+':
                $modifyDate[2] = $modifyDate[2] + $modifyString[1];

                if ($modifyDate[2] > 31) {
                    $modifyDate[1] += intdiv($modifyDate[2], 31);
                    if ($modifyDate[1] < 10) {
                        $modifyDate[1] = '0'.(string)$modifyDate[1];
                    }

                    $modifyDate[2] = $modifyDate[2] % 31;
                    if ($modifyDate[2] < 10) {
                        $modifyDate[2] = '0'.(string)$modifyDate[2];
                    }
                }

                if ($modifyDate[1] > 12) {
                    $modifyDate[0] += intdiv($modifyDate[1], 12);

                    $modifyDate[1] = $modifyDate[1] % 12;
                    if ($modifyDate[1] < 10) {
                        $modifyDate[1] = '0'.(string)$modifyDate[1];
                    }
                }

                break;
        }

        $date = implode('-', $modifyDate);

        return $date;
    }
}
