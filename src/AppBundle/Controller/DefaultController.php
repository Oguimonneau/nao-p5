<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig');
    }

    public function backAction(Request $request)
    {

        return $this->render('default/back.html.twig');
    }

    /**
     * @Security("has_role('ROLE_PARTICULIER') or has_role('ROLE_NATURALISTE')")
     */
    public function addOvservationAction(Request $request)
    {

        return $this->render('default/addObservation.html.twig');
    }

}
