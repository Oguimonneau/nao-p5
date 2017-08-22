<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\ObservationFilterFormType;

class TaxrefController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usr= $this->get('security.token_storage')->getToken()->getUser();


        $form = $this->createForm(ObservationFilterFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $family = $form->getData()['Taxref']->getFamille();
            $observations = $em->getRepository('AppBundle:Observation')->observationByUser($usr, $family);
        }
        return $this->render('default:searchEspece.html.twig', [

            'title'        => 'My Sightings',
            'form'         => $form->createView()
        ]);
    }




}
