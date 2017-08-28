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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Observation');

        $validatedList = $repository->findValidatedLast10();

        return $this->render('default/index.html.twig', array(
            'validatedList' => $validatedList
        ));
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
}
