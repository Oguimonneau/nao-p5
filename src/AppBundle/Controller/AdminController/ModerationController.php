<?php

namespace AppBundle\Controller\AdminController;

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
	public function validateAction($id, Request $request)
	{
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observation = $repository->findOneBy(array('id' => $id));

    	$observation->setValide(true);

    	$em->persist($observation);
    	$em->flush();

    	$request->getSession()->getFlashbag()->add('notice', 'L\'observation n°' . $id . ' a bien été validée.');

        return $this->redirectToRoute('NAO_back_office_validation_list');
	}

	/**
	 * Delete observation
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/deletion/{page}/{id}", name="NAO_back_office_deletion", requirements={"id" = "\d+"})
	 *
	 * @param $id The observation id
	 * @param $page The current page link is used
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function deleteAction($id, $page, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observation = $repository->findOneBy(array('id' => $id));

    	$em->remove($observation);
    	$em->flush();

    	$request->getSession()->getFlashbag()->add('notice', 'L\'observation n°' . $id . ' a bien été supprimée.');

    	return ($page == 'observations') ? $this->redirectToRoute('NAO_back_office_observations_list') : $this->redirectToRoute('NAO_back_office_validation_list');
    }

	/**
	 * Delete user
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
     *
     * @Route("/user-deletion/{page}/{id}", name="NAO_back_office_deletion", requirements={"id" = "\d+"})
	 *
	 * @param $id The user id
	 * @param $page The current page link is used
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function useDeleteAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('UserBundle:User');

    	$user = $repository->findOneBy(array('id' => $id));

    	$em->remove($user);
    	$em->flush();

    	$request->getSession()->getFlashbag()->add('notice', 'L\'utilisateur n°' . $id . ' a bien été supprimé.');

    	return $this->redirectToRoute('NAO_back_office_user_list');
    }
}
