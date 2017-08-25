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
    	/**
    	 * Get all observation to send them in view as a list
    	 *
    	 *	@var $repository AppBundle\Repository\ObservationRepository
    	 */
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observationsList = $repository->findByValide(true);

    	return $this->render('BackOfficeBundle:Default:observationsList.html.twig', array(
    		'observationsList' => $observationsList
    	));
    }

    public function validationListAction()
    {
    	return $this->render('BackOfficeBundle:Default:validationList.html.twig');
    }
}
