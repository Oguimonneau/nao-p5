<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habitat
 *
 * @ORM\Table(name="nao_habitat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HabitatRepository")
 */
class Habitat
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Taxref", mappedBy="habitat")
     */
    private $taxrefs;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Habitat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->taxrefs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add taxref
     *
     * @param \AppBundle\Entity\Taxref $taxref
     *
     * @return Habitat
     */
    public function addTaxref(\AppBundle\Entity\Taxref $taxref)
    {
        $this->taxrefs[] = $taxref;

        return $this;
    }

    /**
     * Remove taxref
     *
     * @param \AppBundle\Entity\Taxref $taxref
     */
    public function removeTaxref(\AppBundle\Entity\Taxref $taxref)
    {
        $this->taxrefs->removeElement($taxref);
    }

    /**
     * Get taxrefs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaxrefs()
    {
        return $this->taxrefs;
    }
}
