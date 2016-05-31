<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CircuitRepository")
 */
class Circuit
{
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="paysDepart", type="string", length=30, nullable=true)
     */
    private $paysDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="villeDepart", type="string", length=30, nullable=true)
     */ells Doctrine to use the category_id column on the product table to relate each record in that table with a record in the category table.
    private $villeDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="villeArrivee", type="string", length=30, nullable=true)
     */
    private $villeArrivee;

    /**
     * @var int
     *
     * @ORM\Column(name="dureeCircuit", type="smallint", nullable=true)
     */
    private $dureeCircuit;


    /**
     *@ORM\OneToMany(targetEntity="CircuitProgramme", mappedBy="circuit")
    */
    protected $programmes;
    
    /**
     *@ORM\OneToMany(targetEntity="Etape", mappedBy="circuit", cascade="REMOVE")
     */
    protected $etapes;
    
    
    
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
     * @return Circuit
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
     * Set paysDepart
     *
     * @param string $paysDepart
     *
     * @return Circuit
     */
    public function setPaysDepart($paysDepart)
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    /**
     * Get paysDepart
     *
     * @return string
     */
    public function getPaysDepart()
    {
        return $this->paysDepart;
    }

    /**
     * Set villeDepart
     *
     * @param string $villeDepart
     *
     * @return Circuit
     */
    public function setVilleDepart($villeDepart)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return string
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param string $villeArrivee
     *
     * @return Circuit
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return string
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set dureeCircuit
     *
     * @param integer $dureeCircuit
     *
     * @return Circuit
     */
    public function setDureeCircuit($dureeCircuit)
    {
        $this->dureeCircuit = $dureeCircuit;

        return $this;
    }

    /**
     * Get dureeCircuit
     *
     * @return int
     */
    public function getDureeCircuit()
    {
        return $this->dureeCircuit;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->programmes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etapes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add programme
     *
     * @param \AppBundle\Entity\CircuitProgramme $programme
     *
     * @return Circuit
     */
    public function addProgramme(\AppBundle\Entity\CircuitProgramme $programme)
    {
        $this->programmes[] = $programme;

        return $this;
    }

    /**
     * Remove programme
     *
     * @param \AppBundle\Entity\CircuitProgramme $programme
     */
    public function removeProgramme(\AppBundle\Entity\CircuitProgramme $programme)
    {
        $this->programmes->removeElement($programme);
    }

    /**
     * Get programmes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgrammes()
    {
        return $this->programmes;
    }

    /**
     * Add etape
     *
     * @param \AppBundle\Entity\Etape $etape
     *
     * @return Circuit
     */
    public function addEtape(\AppBundle\Entity\Etape $etape)
    {
    	$etape->setCircuit($this);
        $this->etapes[] = $etape;
        $this->dureeCircuit= $this->dureeCircuit+$etape->getNombreJours();
        return $this;
    }

    /**
     * Remove etape
     *
     * @param \AppBundle\Entity\Etape $etape
     */
    public function removeEtape(\AppBundle\Entity\Etape $etape)
    {
    	$this->dureeCircuit= $this->dureeCircuit-$etape->getNombreJours();
        $this->etapes->removeElement($etape);
       
    }

    /**
     * Get etapes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtapes()
    {
        return $this->etapes;
    }
}
