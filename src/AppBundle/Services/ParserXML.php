<?php

namespace AppBundle\Services;

/**
 * XML Parser Service
 */
class ParserXML
{
    /**
     * @attr $html the HTML string to parse
     */
    private $html;

    public function __construct(string $html)
    {
        $this->html = $html;
    }



}
