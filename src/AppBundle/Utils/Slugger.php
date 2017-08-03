<?php
/**
 * Created by PhpStorm.
 * User: oguim
 * Date: 03/08/2017
 * Time: 20:56
 */
// src/AppBundle/Utils/Slugger.php
namespace AppBundle\Utils;

class Slugger
{
    public function slugify($string)
    {
        return preg_replace(
            '/[^a-z0-9]/', '-', strtolower(trim(strip_tags($string)))
        );
    }
}