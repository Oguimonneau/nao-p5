<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TaxrefController extends Controller
{
    /**
     * @Route("/searchEspece/{page}", name ="NAO_searchEspece",requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Method({"GET","POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(int $page, Request $request)
    {

        /**
         * Get all validated and invalidated observations to send them in view as a list
         *
         * @repository AppBundle\Repository\TaxrefRepository
         */
        $taxrefsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Taxref')
            ->findTaxrefs($page, 20)

        ;
        return $this->render(':taxref:searchEspece.html.twig', array(
            'taxrefsList' => $taxrefsList,
            'nbPages' => 88,
            'page' => $page
        ));
    }

    /**
     * @Route("/espece/{id}", name ="NAO_detailEspece",requirements={"id" = "\d+"}, defaults={"id" = 1})
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function detailAction(Request $request)
    {
        return $this->render('taxref/detail.html.twig');
    }
}

