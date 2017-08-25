<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModerationController extends Controller
{
	/**
	 * Validate observation
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
}
