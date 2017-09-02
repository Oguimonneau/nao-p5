<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\RechercheFilterFormType;
use AppBundle\Entity\Taxref;
use AppBundle\Entity\Geographie;

class TaxrefController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $taxref = new Taxref();
        $taxref->getNomVern();

        $latitude = new Geographie();
        $longitude = new Geographie();



        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Geographie');

        $latitude = $repository->findAll();


        foreach ($latitude as $geographie) {

            echo $geographie->getCle();
        }



        $form = $this->createForm(RechercheFilterFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $nomVern = $form->getData()['Taxref']->getNomVern();

        }
        return $this->render('default/searchEspece.html.twig', [


            'form'         => $form->createView(),

            'latitude'     =>$latitude ,
            'longitude'    =>$longitude
        ]);
    }
}
