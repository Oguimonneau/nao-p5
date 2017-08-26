<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BackController extends Controller
{
    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$validatedList = $repository->findValidatedLast10();
    	$invalidatedList = $repository->findInvalidatedLast10();

        return $this->render('BackOfficeBundle:Default:index.html.twig', array(
        	'validatedList' => $validatedList,
        	'invalidatedList' => $invalidatedList
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function observationsListAction()
    {
    	/**
    	 * Get all validated observations to send them in view as a list
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

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function validationListAction()
    {
    	/**
    	 * Get all waiting for validation observations to send them in view as a list
    	 *
    	 *	@var $repository AppBundle\Repository\ObservationRepository
    	 */
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observationsList = $repository->findByValide(false);

    	return $this->render('BackOfficeBundle:Default:validationList.html.twig', array(
    		'observationsList' => $observationsList
    	));
    }
}