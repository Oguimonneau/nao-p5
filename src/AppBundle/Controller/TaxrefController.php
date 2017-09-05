<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Repository\TaxrefRepository;
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
         * count number of lines
         *
         * @repository AppBundle\Repository\TaxrefRepository
         */
        $search = $request->query->get('q',"");

        $nbLines = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Taxref')
            ->countTaxrefs($search)
        ;
        $taxrefsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Taxref')
            ->findTaxrefs($page, 20, $search)
        ;

        return $this->render(':taxref:searchEspece.html.twig', array(
            'taxrefsList' => $taxrefsList,
            'nbPages' => ceil ($nbLines/20),
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

