<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackOfficeBundle:Default:index.html.twig');
    }

    public function observationsListAction()
    {
    	return $this->render('BackOfficeBundle:Default:observationsList.html.twig');
    }

    public function validationListAction()
    {
    	return $this->render('BackOfficeBundle:Default:validationList.html.twig');
    }
}
