<?php

namespace AppBundle\Services;

use AppBundle\Entity\Observation;
use AppBundle\Entity\Taxref;

/**
 * XML file creator service
 *
 * Returns an XML file containing Observation's informations
 */
class XMLFileCreator
{
    const TAXREF_STATUS = array(
        'P' => 'Présent(indigène ou indéterminé)',
        'B' => 'Occasionnel',
        'E' => 'Endémique',
        'S' => 'Subendémique',
        'C' => 'Cryptogène',
        'I' => 'Introduit',
        'G' => 'Introduit envahissant',
        'M' => 'Introduit non établi (dont domestique)',
        'D' => 'Douteux',
        'A' => 'Absent',
        'W' => 'Disparu',
        'E' => 'Eteint',
        'Y' => 'Introduit éteint/disparu',
        'Z' => 'Endémique éteint',
        'Q' => 'Mentionné par erreur',
    );

    /**
     * Create XML file
     *
     * @param $observations An array of \AppBundle\Entity\Observation
     */
    public function createObservationXMLFile(array $observations)
    {
        // Start XML file and parent node, sending observations in DOM
        $doc = new \DomDocument('1.0');
        $node = $doc->createElement('markers');
        $markers = $doc->appendChild($node);

        // Iterate through the rows, printing XML nodes for each
        foreach ($observations as $observation)
        {
            $marker = $doc->createElement('marker');
            $newMarker = $markers->appendChild($marker);

            $newMarker->setAttribute('id', $observation->getId());
            $newMarker->setAttribute('lat', $observation->getLatitude());
            $newMarker->setAttribute('lng', $observation->getLongitude());
            $newMarker->setAttribute('com', $observation->getCommune());
        }

        $xmlfile = $doc->saveXML();
        return $xmlfile;
    }

    /**
     * Create XML file
     *
     * @param $observations An object \AppBundle\Entity\taxref
     */
    public function createStatusXMLFile(\AppBundle\Entity\Taxref $taxref)
    {
        // Start XML file and parent node, sending taxref's geographic status in DOM
        $doc = new \DomDocument('1.0');
        $node = $doc->createElement('status');
        $status = $doc->appendChild($node);

        // Get status if exists in zone
        if ($taxref->getFr() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('fr', self::TAXREF_STATUS[$taxref->getFr()]);
        }

        if ($taxref->getGf() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('gf', self::TAXREF_STATUS[$taxref->getGf()]);
        }

        if ($taxref->getMar() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('mar', self::TAXREF_STATUS[$taxref->getMar()]);
        }

        if ($taxref->getGua() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('gua', self::TAXREF_STATUS[$taxref->getGua()]);
        }

        if ($taxref->getSm() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('sm', self::TAXREF_STATUS[$taxref->getSm()]);
        }

        if ($taxref->getSb() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('sb', self::TAXREF_STATUS[$taxref->getSb()]);
        }

        if ($taxref->getSpm() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('spm', self::TAXREF_STATUS[$taxref->getSpm()]);
        }

        if ($taxref->getMay() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('may', self::TAXREF_STATUS[$taxref->getMay()]);
        }

        if ($taxref->getEpa() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('epa', self::TAXREF_STATUS[$taxref->getEpa()]);
        }

        if ($taxref->getReu() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('reu', self::TAXREF_STATUS[$taxref->getReu()]);
        }

        if ($taxref->getSa() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('sa', self::TAXREF_STATUS[$taxref->getSa()]);
        }

        if ($taxref->getTa() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('ta', self::TAXREF_STATUS[$taxref->getTa()]);
        }

        if ($taxref->getTaaf() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('taaf', self::TAXREF_STATUS[$taxref->getTaaf()]);
        }

        if ($taxref->getPf() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('pf', self::TAXREF_STATUS[$taxref->getPf()]);
        }

        if ($taxref->getNc() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('nc', self::TAXREF_STATUS[$taxref->getNc()]);
        }

        if ($taxref->getWf() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('wf', self::TAXREF_STATUS[$taxref->getWf()]);
        }

        if ($taxref->getCli() !== '')
        {
            $state = $doc->createElement('state');
            $newState = $status->appendChild($state);

            $newState->setAttribute('cli', self::TAXREF_STATUS[$taxref->getCli()]);
        }

        $xmlfile = $doc->saveXML();
        return $xmlfile;
    }
}
