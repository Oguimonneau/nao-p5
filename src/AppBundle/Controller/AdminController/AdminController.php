<?php

namespace AppBundle\Controller\AdminController;

use AppBundle\Entity\Observation;
use UserBundle\Entity\User;
use AppBundle\Form\AdminType\ObservationEditType;
use AppBundle\Form\AdminType\UserEditType;
use AppBundle\Form\AdminType\SortingType;
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
         * Get last 10 validated and invalidated observations to send them in view as a list
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

        /**
         * Get last 10 users
         *
         * @repository UserBundle\Repository\UserRepository
         */
        $userList = $this->getDoctrine()
            ->getManager()
            ->getRepository('UserBundle:User')
            ->findBy(array(), array(), self::NB_PER_PAGE)
        ;

        return $this->render('admin/index.html.twig', array(
        	'validatedList' => $validatedList,
        	'invalidatedList' => $invalidatedList,
            'userList' => $userList
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/observations-list/{page}", name="NAO_back_office_observations_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function observationsListAction(int $page, Request $request)
    {
        /**
         * Sorting Form
         *
         * Change number of items shown per page when submitted
         *
         * @FormType AppBundle\Form\AdminType\SortingType
         */
        $sortingForm = $this->get('form.factory')->create(SortingType::class);

        if ($request->isMethod('POST') && $sortingForm->handleRequest($request)->isValid())
        {
            $request->getSession()->set('nbPerPage', $sortingForm['nbPerPageSelect']->getData());
        }

        /**
         * Get all validated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(
                $page,
                // If Sorting Form is submitted, its POST data replaces const NB_PER_PAGE
                ($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE, 
                1
            )
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / (($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE));

        // Set nbPages < 1 to 1
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;

        // Check if page number is valid
        if ($page == 0 || $page > $nbPages)
        {
            return $this->redirectToRoute('NAO_back_office_observations_list');
        }


    	return $this->render('admin/observationsList.html.twig', array(
    		'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page,
            'sorting' => $sortingForm->createView()
    	));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/validation-list/{page}", name="NAO_back_office_validation_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function validationListAction(int $page, Request $request)
    {
        /**
         * Sorting Form
         *
         * Change number of items shown per page when submitted
         *
         * @FormType AppBundle\Form\AdminType\SortingType
         */
        $sortingForm = $this->get('form.factory')->create(SortingType::class);

        if ($request->isMethod('POST') && $sortingForm->handleRequest($request)->isValid())
        {
            $request->getSession()->set('nbPerPage', $sortingForm['nbPerPageSelect']->getData());
        }

        /**
         * Get all validated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\ObservationRepository
         */
        $observationsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findObservations(
                $page,
                // If Sorting Form is submitted, its POST data replaces const NB_PER_PAGE
                ($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE, 
                0
            )
        ;

        // Calculate total number of pages
        // Count($observationsList) returns total number of observations
        $nbPages = ceil(count($observationsList) / (($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE));

        // Set nbPages < 1 to 1
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;

        // Check if page number is valid
        if ($page == 0 || $page > $nbPages)
        {
            return $this->redirectToRoute('NAO_back_office_validation_list');
        }

        return $this->render('admin/validationList.html.twig', array(
            'observationsList' => $observationsList,
            'nbPages' => $nbPages,
            'page' => $page,
            'sorting' => $sortingForm->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/observation/{id}/edit", name="NAO_back_office_modification", requirements={"id" = "\d+"})
     *
     */
    public function modificationAction(Observation $observation, Request $request)
    {
        $form = $this->get('form.factory')->create(ObservationEditType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'L\'observation n°' . $observation->getId() . ' a bien été modifiée.');

            return $this->redirectToRoute('NAO_back_office_observations_list', array('page' => 1));
        }

        return $this->render('admin/modification.html.twig', array(
            'observation' => $observation,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user/{page}", name="NAO_back_office_user_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function userListAction(int $page, Request $request)
    {
        /**
         * Sorting Form
         *
         * Change number of items shown per page when submitted
         *
         * @FormType AppBundle\Form\AdminType\SortingType
         */
        $sortingForm = $this->get('form.factory')->create(SortingType::class);

        if ($request->isMethod('POST') && $sortingForm->handleRequest($request)->isValid())
        {
            $request->getSession()->set('nbPerPage', $sortingForm['nbPerPageSelect']->getData());
        }

        /**
         * Get list of all users
         *
         * @repository UserBundle\Repository\UserRepository
         */
        $userList = $this->getDoctrine()
            ->getManager()
            ->getRepository('UserBundle:User')
            ->findUsers(
                $page, 
                ($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE
            )
        ;

        // Calculate total number of pages
        // Count($userList) returns total number of observations
        $nbPages = ceil(count($userList) / (($request->getSession()->get('nbPerPage') !== null) ? $request->getSession()->get('nbPerPage') : self::NB_PER_PAGE));

        // Set nbPages < 1 to 1
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;

        // Check if page number is valid
        if ($page == 0 || $page > $nbPages)
        {
            return $this->redirectToRoute('NAO_back_office_user_list');
        }

        return $this->render('admin/userList.html.twig', array(
            'userList' => $userList,
            'nbPages' => $nbPages,
            'page' => $page,
            'sorting' => $sortingForm->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user/{id}/edit", name="NAO_back_office_user_edit", requirements={"id" = "\d+"})
     */
    public function userEditAction(User $user, Request $request)
    {
        return $this->render('admin/userEdit.html.twig', array(
            'user' => $user
        ));
    }
}
