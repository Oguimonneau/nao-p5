<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackOfficeBundle:Default:index.html.twig');
    }
}
