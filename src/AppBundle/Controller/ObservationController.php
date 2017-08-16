<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Observation;
use AppBundle\Entity\Taxref;
use UserBundle\Entity\User;
use AppBundle\Form\ObservationType;

class ObservationController extends Controller
{
    /**
     * @Security("has_role('ROLE_PARTICULIER') or has_role('ROLE_NATURALISTE')")
     */
    public function addAction(Request $request)
    {
        $observation = new Observation();

        $form = $this->get('form.factory')->create(ObservationType::class, $observation);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // On fait le lien avec l'utilisateur en cours
            $observation->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Observation bien enregistrée.');

            return $this->redirectToRoute('NAO_home');
        }

        return $this->render('default/addObservation.html.twig', array(
            'form' => $form->createView(),
        ));
    }

//return $this->render('default/addObservation.html.twig');

    public function listAction(Request $request)
    {

        return $this->render('default/listObservation.html.twig');
    }

}
