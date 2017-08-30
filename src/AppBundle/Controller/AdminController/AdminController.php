<?php

namespace AppBundle\Controller\AdminController;

use AppBundle\Form\ObservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    const NB_PER_PAGE = 10;

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/", name="NAO_back")
     */
    public function indexAction()
    {
        /**
         * Get all validated and invalidated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $validatedList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(1, self::NB_PER_PAGE, 1)
        ;

        $invalidatedList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(1, self::NB_PER_PAGE, 0)
        ;

        return $this->render('admin/index.html.twig', array(
        	'validatedList' => $validatedList,
        	'invalidatedList' => $invalidatedList
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/observations-list/{page}", name="NAO_back_office_observations_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function observationsListAction(int $page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
        }

    	/**
    	 * Get all validated observations to send them in view as a list
    	 *
    	 * @repository AppBundle\Repository\ObservationRepository
    	 */
    	$observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations($page, self::NB_PER_PAGE, 1)
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / self::NB_PER_PAGE);

        // If at least 1 entry exists in array,
        // Check if page doesn't exist, returns 404 error
        if ($nbPages > 0)
        {
          if ($page > $nbPages)
            {
                throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
            }
        }

    	return $this->render('admin/observationsList.html.twig', array(
    		'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page
    	));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/validation-list/{page}", name="NAO_back_office_validation_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function validationListAction(int $page)
    {
        if ($page < 1)
        {
            throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
        }

        /**
         * Get all invalidated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations($page, self::NB_PER_PAGE, 0)
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / self::NB_PER_PAGE);

        // If at least 1 entry exists in array,
        // Check if page doesn't exist, returns 404 error
        if ($nbPages > 0)
        {
          if ($page > $nbPages)
            {
                throw $this->createNotFoundException('La page n°' . $page . ' n\'existe pas.');
            }
        }

        return $this->render('admin/validationList.html.twig', array(
            'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/observation/{id}/edit", name="NAO_back_office_modification", requirements={"id" = "\d+"})
     */
    public function modificationAction(int $id, Request $request)
    {
        // if ($id < 1 || !is_int($id))
        // {
        //     throw $this->createNotFoundException('Cette page n\'existe pas');
        // }

        /**
         * Get observation's content
         */
        $observation = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findOneBy(array('id' => $id))
        ;

        $form = $this->get('form.factory')->create(ObservationType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'L\'observation n°' . $observation->getId() . ' a bien été modifiée.');

            return $this->redirectToRoute('NAO_back_office_observations_list', array('page' => 1));
        }

        return $this->render('admin/modification.html.twig', array(
            'observation' => $observation,
            'form' => $form->createView()
        ));
    }
}
