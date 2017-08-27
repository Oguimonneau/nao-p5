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
        // Fix number of observations per page
        $nbPerPage = 10;

        /**
         * Get all validated and invalidated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $validatedList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(1, $nbPerPage, 1)
        ;

        $invalidatedList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(1, $nbPerPage, 0)
        ;

        return $this->render('BackOfficeBundle:Default:index.html.twig', array(
        	'validatedList' => $validatedList,
        	'invalidatedList' => $invalidatedList
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function observationsListAction($page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
        }

        // Fix number of observations per page
        $nbPerPage = 10;

    	/**
    	 * Get all validated observations to send them in view as a list
    	 *
    	 * @repository AppBundle\Repository\ObservationRepository
    	 */
    	$observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations($page, $nbPerPage, 1)
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / $nbPerPage);

        // If at least 1 entry exists in array,
        // Check if page doesn't exist, returns 404 error
        if ($nbPages > 0)
        {
          if ($page > $nbPages)
            {
                throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
            }
        }

    	return $this->render('BackOfficeBundle:Default:observationsList.html.twig', array(
    		'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page
    	));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function validationListAction($page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
        }

        // Fix number of observations per page
        $nbPerPage = 10;

        /**
         * Get all invalidated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations($page, $nbPerPage, 0)
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / $nbPerPage);

        // If at least 1 entry exists in array,
        // Check if page doesn't exist, returns 404 error
        if ($nbPages > 0)
        {
          if ($page > $nbPages)
            {
                throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
            }
        }

        return $this->render('BackOfficeBundle:Default:validationList.html.twig', array(
            'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }
}
