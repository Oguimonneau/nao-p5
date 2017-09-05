<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Taxref
 *
 * @ORM\Table(name="nao_taxref", indexes={@ORM\Index(name="nom_vern_idx", columns={"nom_vern"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefRepository")
 */
class Taxref
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Habitat", inversedBy="taxrefs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $habitat;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="cd_nom", type="integer")
     */
    private $cdNom;
    /**
     * @var int
     *
     * @ORM\Column(name="cd_sup", type="integer", nullable=false, unique=false)
     */
    private $cdSup;

    /**
     * @var string
     *
     * @ORM\Column(name="rang", type="string", length=4)
     */
    private $rang;
    /**
     * @var string
     *
     * @ORM\Column(name="lb_nom", type="string", length=255)
     */
    private $lbNom;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_auteur", type="string", length=255)
     */
    private $lbAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern", type="string", length=255)
     */
    private $nomVern;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern_eng", type="string", length=255)
     */
    private $nomVernEng;


    /**
     * @var string
     *
     * @ORM\Column(name="fr", type="string", length=1)
     */
    private $fr;

    /**
     * @var string
     *
     * @ORM\Column(name="gf", type="string", length=1)
     */
    private $gf;

    /**
     * @var string
     *
     * @ORM\Column(name="mar", type="string", length=1)
     */
    private $mar;

    /**
     * @var string
     *
     * @ORM\Column(name="gua", type="string", length=1)
     */
    private $gua;

    /**
     * @var string
     *
     * @ORM\Column(name="sm", type="string", length=1)
     */
    private $sm;

    /**
     * @var string
     *
     * @ORM\Column(name="sb", type="string", length=1)
     */
    private $sb;

    /**
     * @var string
     *
     * @ORM\Column(name="spm", type="string", length=1)
     */
    private $spm;

    /**
     * @var string
     *
     * @ORM\Column(name="may", type="string", length=1)
     */
    private $may;

    /**
     * @var string
     *
     * @ORM\Column(name="epa", type="string", length=1)
     */
    private $epa;

    /**
     * @var string
     *
     * @ORM\Column(name="reu", type="string", length=1)
     */
    private $reu;

    /**
     * @var string
     *
     * @ORM\Column(name="sa", type="string", length=1)
     */
    private $sa;

    /**
     * @var string
     *
     * @ORM\Column(name="ta", type="string", length=1)
     */
    private $ta;

    /**
     * @var string
     *
     * @ORM\Column(name="taaf", type="string", length=1)
     */
    private $taaf;

    /**
     * @var string
     *
     * @ORM\Column(name="pf", type="string", length=1)
     */
    private $pf;

    /**
     * @var string
     *
     * @ORM\Column(name="nc", type="string", length=1)
     */
    private $nc;

    /**
     * @var string
     *
     * @ORM\Column(name="wf", type="string", length=1)
     */
    private $wf;

    /**
     * @var string
     *
     * @ORM\Column(name="cli", type="string", length=1)
     */
    private $cli;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=12)
     */
    private $image;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

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
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return Taxref
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return int
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdSup
     *
     * @return Taxref
     */
    public function setCdSup($cdSup)
    {
        $this->cdNom = $cdSup;

        return $this;
    }

    /**
     * Get cdSup
     *
     * @return int
     */
    public function getCdSup()
    {
        return $this->cdSup;
    }

    /**
     * Set rang
     *
     * @param string $rang
     *
     * @return Taxref
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return string
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set lbNom
     *
     * @param string $lbNom
     *
     * @return Taxref
     */
    public function setLbNom($lbNom)
    {
        $this->lbNom = $lbNom;

        return $this;
    }

    /**
     * Get lbNom
     *
     * @return string
     */
    public function getLbNom()
    {
        return $this->lbNom;
    }

    /**
     * Set lbAuteur
     *
     * @param string $lbAuteur
     *
     * @return Taxref
     */
    public function setLbAuteur($lbAuteur)
    {
        $this->lbAuteur = $lbAuteur;

        return $this;
    }

    /**
     * Get lbAuteur
     *
     * @return string
     */
    public function getLbAuteur()
    {
        return $this->lbAuteur;
    }

    /**
     * Set nomVern
     *
     * @param string $nomVern
     *
     * @return Taxref
     */
    public function setNomVern($nomVern)
    {
        $this->nomVern = $nomVern;

        return $this;
    }

    /**
     * Get nomVern
     *
     * @return string
     */
    public function getNomVern()
    {
        return $this->nomVern;
    }

    /**
     * Set nomVernEng
     *
     * @param string $nomVernEng
     *
     * @return Taxref
     */
    public function setNomVernEng($nomVernEng)
    {
        $this->nomVernEng = $nomVernEng;

        return $this;
    }

    /**
     * Get nomVernEng
     *
     * @return string
     */
    public function getNomVernEng()
    {
        return $this->nomVernEng;
    }

    /**
     * Set habitat
     *
     * @param integer $habitat
     *
     * @return Taxref
     */
    public function setHabitat($habitat)
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * Get habitat
     *
     * @return int
     */
    public function getHabitat()
    {
        return $this->habitat;
    }

    /**
     * Set fr
     *
     * @param string $fr
     *
     * @return Taxref
     */
    public function setFr($fr)
    {
        $this->fr = $fr;

        return $this;
    }

    /**
     * Get fr
     *
     * @return string
     */
    public function getFr()
    {
        return $this->fr;
    }

    /**
     * Set gf
     *
     * @param string $gf
     *
     * @return Taxref
     */
    public function setGf($gf)
    {
        $this->gf = $gf;

        return $this;
    }

    /**
     * Get gf
     *
     * @return string
     */
    public function getGf()
    {
        return $this->gf;
    }

    /**
     * Set mar
     *
     * @param string $mar
     *
     * @return Taxref
     */
    public function setMar($mar)
    {
        $this->mar = $mar;

        return $this;
    }

    /**
     * Get mar
     *
     * @return string
     */
    public function getMar()
    {
        return $this->mar;
    }

    /**
     * Set gua
     *
     * @param string $gua
     *
     * @return Taxref
     */
    public function setGua($gua)
    {
        $this->gua = $gua;

        return $this;
    }

    /**
     * Get gua
     *
     * @return string
     */
    public function getGua()
    {
        return $this->gua;
    }

    /**
     * Set sm
     *
     * @param string $sm
     *
     * @return Taxref
     */
    public function setSm($sm)
    {
        $this->sm = $sm;

        return $this;
    }

    /**
     * Get sm
     *
     * @return string
     */
    public function getSm()
    {
        return $this->sm;
    }

    /**
     * Set sb
     *
     * @param string $sb
     *
     * @return Taxref
     */
    public function setSb($sb)
    {
        $this->sb = $sb;

        return $this;
    }

    /**
     * Get sb
     *
     * @return string
     */
    public function getSb()
    {
        return $this->sb;
    }

    /**
     * Set spm
     *
     * @param string $spm
     *
     * @return Taxref
     */
    public function setSpm($spm)
    {
        $this->spm = $spm;

        return $this;
    }

    /**
     * Get spm
     *
     * @return string
     */
    public function getSpm()
    {
        return $this->spm;
    }

    /**
     * Set may
     *
     * @param string $may
     *
     * @return Taxref
     */
    public function setMay($may)
    {
        $this->may = $may;

        return $this;
    }

    /**
     * Get may
     *
     * @return string
     */
    public function getMay()
    {
        return $this->may;
    }

    /**
     * Set epa
     *
     * @param string $epa
     *
     * @return Taxref
     */
    public function setEpa($epa)
    {
        $this->epa = $epa;

        return $this;
    }

    /**
     * Get epa
     *
     * @return string
     */
    public function getEpa()
    {
        return $this->epa;
    }

    /**
     * Set reu
     *
     * @param string $reu
     *
     * @return Taxref
     */
    public function setReu($reu)
    {
        $this->reu = $reu;

        return $this;
    }

    /**
     * Get reu
     *
     * @return string
     */
    public function getReu()
    {
        return $this->reu;
    }

    /**
     * Set sa
     *
     * @param string $sa
     *
     * @return Taxref
     */
    public function setSa($sa)
    {
        $this->sa = $sa;

        return $this;
    }

    /**
     * Get sa
     *
     * @return string
     */
    public function getSa()
    {
        return $this->sa;
    }

    /**
     * Set ta
     *
     * @param string $ta
     *
     * @return Taxref
     */
    public function setTa($ta)
    {
        $this->ta = $ta;

        return $this;
    }

    /**
     * Get ta
     *
     * @return string
     */
    public function getTa()
    {
        return $this->ta;
    }

    /**
     * Set taaf
     *
     * @param string $taaf
     *
     * @return Taxref
     */
    public function setTaaf($taaf)
    {
        $this->taaf = $taaf;

        return $this;
    }

    /**
     * Get taaf
     *
     * @return string
     */
    public function getTaaf()
    {
        return $this->taaf;
    }

    /**
     * Set pf
     *
     * @param string $pf
     *
     * @return Taxref
     */
    public function setPf($pf)
    {
        $this->pf = $pf;

        return $this;
    }

    /**
     * Get pf
     *
     * @return string
     */
    public function getPf()
    {
        return $this->pf;
    }

    /**
     * Set nc
     *
     * @param string $nc
     *
     * @return Taxref
     */
    public function setNc($nc)
    {
        $this->nc = $nc;

        return $this;
    }

    /**
     * Get nc
     *
     * @return string
     */
    public function getNc()
    {
        return $this->nc;
    }

    /**
     * Set wf
     *
     * @param string $wf
     *
     * @return Taxref
     */
    public function setWf($wf)
    {
        $this->wf = $wf;

        return $this;
    }

    /**
     * Get wf
     *
     * @return string
     */
    public function getWf()
    {
        return $this->wf;
    }

    /**
     * Set cli
     *
     * @param string $cli
     *
     * @return Taxref
     */
    public function setCli($cli)
    {
        $this->cli = $cli;

        return $this;
    }

    /**
     * Get cli
     *
     * @return string
     */
    public function getCli()
    {
        return $this->cli;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Taxref
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
