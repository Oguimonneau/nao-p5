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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ObservationController extends Controller
{

    /**
     * @Route("/observation/{observationId}", name ="NAO_detail_observation",requirements={"observationId" = "\d+"})
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(int $observationId)
    {
        $observation = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findOneById($observationId);
        return $this->render('taxref/detailObservation.html.twig', array(
            'observation' => $observation));
    }

    /**
     * @Route("/observation/add", name ="NAO_addObservation")
     * @Method({"GET","POST"})
     * @Security("has_role('ROLE_PARTICULIER') or has_role('ROLE_NATURALISTE')")
     */
    public function addAction(Request $request)
    {
        $observation = new Observation();
        $form = $this->get('form.factory')->create(ObservationType::class, $observation);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // On fait le lien avec l'utilisateur en cours
            $observation->setUser($this->getUser());
            if ($observation->getPhoto()->getFile() === null) {
                $observation->setPhoto(null);
            }
            //On déplace l'immage
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
}

