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
     * @Route("/espece/{id}/{page}", name ="NAO_detailEspece", requirements={"id" = "\d+", "page" = "\d+"}, defaults={"page" = 1})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function detailAction(int $page, int $id, Request $request)
    {
        // Find taxref by id
        $taxref = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Taxref')
            ->findOneById($id)
        ;

        // Find taxref's related observations with paging
        $observations = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findValidatedObservationsByTaxref($taxref->getId(), $page)
        ;
        
        function parseToXML($htmlStr)
        {
            $xmlStr=str_replace('<','&lt;',$htmlStr);
            $xmlStr=str_replace('>','&gt;',$xmlStr);
            $xmlStr=str_replace('"','&quot;',$xmlStr);
            $xmlStr=str_replace("'",'&#39;',$xmlStr);
            $xmlStr=str_replace("&",'&amp;',$xmlStr);
            return $xmlStr;
        }

        // Star XML echo node, sending taxref's geographic status
        echo '<status>';
        // Get status if exists in zone
        if ($taxref->getFr() !== null)
        {
            echo '<state ';
            // echo 'fr="' . $taxref->getFr()->getLibelle() . '" ';
            echo '/>';
        }

        // End XML echo node
        echo '</status>';

        // Start XML echo node, sending observations
        echo '<markers>';

        // Iterate through the rows, printing XML nodes for each
        foreach ($observations as $observation)
        {
            // Add to XML document node
            echo '<marker ';
            echo 'id="' . $observation->getId() . '" ';
            // echo 'img="' . $observation->getPhoto() . '" ';
            echo 'lat="' . $observation->getLatitude() . '" ';
            echo 'lng="' . $observation->getLongitude() . '" ';
            echo 'com="' . parseToXML($observation->getCommune()) . '" ';
            echo 'note="' . parseToXML($observation->getNote()) . '" ';
            echo '/>';
        }

        // End XML echo node
        echo '</markers>';

        // Calculate total number of pages
        // Count($observations) returns total number of observations
        $nbPages = ceil(count($observations) / 4);

        // If at least 1 entry exists in array,
        // Check if page doesn't exist, returns to page 1
        if ($nbPages > 0)
        {
          if ($page > $nbPages)
            {
                return $this->redirectToRoute('NAO_detailEspece');
            }
        }

        return $this->render('taxref/detail.html.twig', array(
           'taxref' => $taxref,
           'observations' => $observations,
           'page' => $page,
           'nbPages' => $nbPages
        ));
    }
}

