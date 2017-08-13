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

    public function contactAction(Request $request)
    {

        return $this->render('default/contact.html.twig');
    }
    public function aboutAction(Request $request)
    {

        return $this->render('default/about.html.twig');
    }

    public function backAction(Request $request)
    {
        return $this->render('default/back.html.twig');
    }

    public function mentionsAction(Request $request)
    {
        return $this->render('default/mentions.html.twig');
    }

    public function conditionsAction(Request $request)
    {
        return $this->render('default/conditions.html.twig');
    }

    /**
     * @Security("has_role('ROLE_PARTICULIER') or has_role('ROLE_NATURALISTE')")
     */
    public function addObservationAction(Request $request)
    {

        return $this->render('default/addObservation.html.twig');
    }

    public function listObservationAction(Request $request)
    {

        return $this->render('default/listObservation.html.twig');
    }

}
