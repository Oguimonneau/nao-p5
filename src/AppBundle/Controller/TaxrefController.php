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

        $latutude = new Geographie();
        $latutude ->$repository->find($id);

        $longitude = new Geographie();
        $longitude ->getLongitude();
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Geographie');



        $latutude = $repository->findAll();

        foreach ($latitude as $geographie) {

            echo $geographie->getLatitude();
        }



        $form = $this->createForm(RechercheFilterFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $nomVern = $form->getData()['Taxref']->getNomVern();

        }
        return $this->render('default/searchEspece.html.twig', [


            'form'         => $form->createView(),

            'latitude'     =>$latutude ->getLatitude(),
            'longitude'    =>$longitude ->getLongitude()
        ]);
    }
}
