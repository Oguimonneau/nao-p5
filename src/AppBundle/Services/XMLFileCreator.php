<?php

namespace AppBundle\Services;

use AppBundle\Entity\Observation;

/**
 * XML file creator service
 *
 * Returns an XML file containing Observation's informations
 */
class XMLFileCreator
{
    /**
     * Create XML file
     *
     * @param $observations An array of \AppBundle\Entity\Observation
     */
    public function createXMLFile(array $observations)
    {
        // Start XML file and parent node, sending observations in DOM
        $doc = new \DomDocument('1.0');
        $node = $doc->createElement('markers');
        $markers = $doc->appendChild($node);

        // Iterate through the rows, printing XML nodes for each
        foreach ($observations as $observation)
        {
            $marker = $doc->createElement("marker");
            $newMarker = $markers->appendChild($marker);

            $newMarker->setAttribute("id", $observation->getId());
            $newMarker->setAttribute("lat", $observation->getLatitude());
            $newMarker->setAttribute("lng", $observation->getLongitude());
            $newMarker->setAttribute("com", $observation->getCommune());
        }

        $xmlfile = $doc->saveXML();
        return $xmlfile;
    }
}
