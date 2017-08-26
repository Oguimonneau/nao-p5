<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ModerationController extends Controller
{
	/**
	 * Validate observation
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
	 *
	 * @param $id The observation id
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function validateAction($id)
	{
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observation = $repository->findOneBy(array('id' => $id));

    	$observation->setValide(true);

    	$em->persist($observation);
    	$em->flush();

        return $this->redirectToRoute('NAO_back_office_validation_list');
	}

	/**
	 * Validate observation
	 *
	 * @Security("has_role('ROLE_NATURALISTE')")
	 *
	 * @param $id The observation id
	 * @param $page The current page link is used
	 * Redirect to route BackOfficeBundle/Resources/views/Default:validationList.html.twig 
	 */
	public function deleteAction($id, $page)
	{
		$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Observation');

    	$observation = $repository->findOneBy(array('id' => $id));

    	$em->remove($observation);
    	$em->flush();

    	return ($page == 'observations') ? $this->redirectToRoute('NAO_back_office_observations_list') : $this->redirectToRoute('NAO_back_office_validation_list');
    }
}
