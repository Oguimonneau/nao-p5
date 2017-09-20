<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Taxref;
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
     * @Route("/espece/{id}/{page}", name ="NAO_detailEspece", requirements={"id" = "\d+", "page" = "\d+"}, defaults={"page" = 1})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function detailAction(int $page, Taxref $taxref, Request $request)
    {
        // Find taxref's related validated observations with paging (list)
        $observationsPaginator = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findValidatedObservationsByTaxref($taxref->getId(), $page)
        ;

        // Calculate total number of pages
        // Count($observationsPaginator) returns total number of observations
        $nbPages = ceil(count($observationsPaginator) / 8);

        // Set nbPages < 1 to 1
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;

        // Check if page number is valid
        if ($page == 0 || $page > $nbPages)
        {
            return $this->redirectToRoute('NAO_detailEspece', array('id' => $taxref->getId()));
        }

        return $this->render('taxref/detail.html.twig', array(
           'taxref' => $taxref,
           'observationsPaginator' => $observationsPaginator,
           'page' => $page,
           'nbPages' => $nbPages
        ));
    }

    /**
     * @Route("/parser-api/{id}/taxref.{_format}", name ="NAO_xml_taxref_infos_api", requirements={"id" = "\d+"}, defaults={"_format" = "xml"})
     *
     * @return xml document with Observation informations
     */
    public function buildXmlObservationsAction(Taxref $taxref, Request $request)
    {
        // Find taxref's related validated observations
        $observations = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findBy(array('taxref' => $taxref->getId(), 'valide' => 1))
        ;

        return $this->render('taxref/xml/taxrefInformations.xml.twig', array(
            'taxref' => $taxref,
            'observations' => $observations
        ));
    }
}

