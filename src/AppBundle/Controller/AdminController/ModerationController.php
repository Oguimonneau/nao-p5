<?php

namespace AppBundle\Controller\AdminController;

use AppBundle\Entity\Observation;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ModerationController extends Controller
{
	/**
	 * Validate observation
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/validation/{id}", name="NAO_back_office_validation", requirements={"id" = "\d+"})
	 *
	 * @param $id The observation id
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function validateAction(Observation $observation, Request $request)
	{
    	$observation->setValide(true);

        $em = $this->getDoctrine()->getManager();

    	$em->flush();

    	$request->getSession()->getFlashbag()->add('notice', 'L\'observation n°' . $observation->getId() . ' a bien été validée.');

        return $this->redirectToRoute('NAO_back_office_validation_list');
	}

	/**
	 * Delete observation
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/deletion/{page}/{id}", name="NAO_back_office_observation_deletion", requirements={"id" = "\d+"})
	 *
	 * @param $id The observation id
	 * @param $page The current page link is used
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function deleteAction(Observation $observation, $page, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        $observationId = $observation->getId();

    	$em->remove($observation);
    	$em->flush();

    	$request->getSession()->getFlashbag()->add('notice', 'L\'observation n°' . $observationId . ' a bien été supprimée.');

    	return ($page == 'observations') ? $this->redirectToRoute('NAO_back_office_observations_list') : $this->redirectToRoute('NAO_back_office_validation_list');
    }

	/**
	 * Delete user
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user-deletion/{id}", name="NAO_back_office_user_deletion", requirements={"id" = "\d+"})
	 *
	 * @param $id The user id
	 * Redirect to route BackOfficeBundle/Resources/views/Default:userList.html.twig 
	 */
	public function userDeleteAction(User $user, Request $request)
	{
		// Get FOSUserBundle UserManager
		$userManager = $this->get('fos_user.user_manager');

        $userId = $user->getId();

		// Delete user
		$userManager->deleteUser($user);

    	$request->getSession()->getFlashbag()->add('notice', 'L\'utilisateur n°' . $userId . ' a bien été supprimé.');

    	return $this->redirectToRoute('NAO_back_office_user_list');
    }

    /**
     * Promote User to Naturalist
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user/{id}/edit/promote", name="NAO_back_office_user_promotion", requirements={"id" = "\d+"})
	 *
	 * @param $id The user id
	 * Redirect to route BackOfficeBundle/Resources/views/Default:userList.html.twig 
	 */
    public function userPromoteAction(User $user, Request $request)
    {
    	$userManager = $this->get('fos_user.user_manager');

    	// Update user
    	$user->addRole('ROLE_NATURALISTE');
    	$userManager->updateUser($user);

    	$request->getSession()->getFlashBag()->add('notice', 'L\'utilisateur n°' . $user->getId() . ' a bien été mis à jour.');

        return $this->redirectToRoute('NAO_back_office_user_list', array('page' => 1));
    }

    /**
     * Demote User to Naturalist
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user/{id}/edit/demote", name="NAO_back_office_user_demotion", requirements={"id" = "\d+"})
	 *
	 * @param $id The user id
	 * Redirect to route BackOfficeBundle/Resources/views/Default:userList.html.twig 
	 */
    public function userDemoteAction(User $user, Request $request)
    {
    	$userManager = $this->get('fos_user.user_manager');

    	// Update User
    	$user->removeRole('ROLE_NATURALISTE');
    	$userManager->updateUser($user);

    	$request->getSession()->getFlashBag()->add('notice', 'L\'utilisateur n°' . $user->getId() . ' a bien été mis à jour.');

        return $this->redirectToRoute('NAO_back_office_user_list', array('page' => 1));    	
    }    
}
