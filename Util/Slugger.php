<?php

namespace Enguys\CoreBundle\Util;

class Slugger
{
    /**
     * @param string $string
     *
     * @return string
     */
    public static function slugify($string)
    {
        return preg_replace('/([^A-Za-z0-9]|-)+/', '-', mb_strtolower(trim(strip_tags($string)), 'UTF-8'));
    }
}
