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
     * @Route("/espece/{id}", name ="NAO_detailEspece",requirements={"id" = "\d+"})
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function detailAction(int $id, Request $request)
    {
        // Find taxref by id
        $taxref = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Taxref')
            ->findOneById($id)
        ;

        // Find taxref's related observations
        $observations = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findByTaxref($taxref->getId())
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

        // header("Content-type: text/xml");

        // Start XML file, echo parent node
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

        // End XML file
        echo '</markers>';

        return $this->render('taxref/detail.html.twig', array(
           'taxref' => $taxref,
           'observations' => $observations
        ));
    }
}

