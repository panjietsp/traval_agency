<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CircuitProgramme
 *
 * @ORM\Table(name="circuit_programme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CircuitProgrammeRepository")
 */
class CircuitProgramme
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDepart", type="date")
     */
    private $dateDepart;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePersonnes", type="integer")
     */
    private $nombrePersonnes;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="smallint", nullable=true)
     */
    private $prix;

    
    /**
     * @ORM\ManyToOne(targetEntity="Circuit", inversedBy="programmes")
     * @ORM\JoinColumn(name="circuit_id", referencedColumnName="id")
     */
    protected $circuit;
    
    

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
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return CircuitProgramme
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set nombrePersonnes
     *
     * @param integer $nombrePersonnes
     *
     * @return CircuitProgramme
     */
    public function setNombrePersonnes($nombrePersonnes)
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    /**
     * Get nombrePersonnes
     *
     * @return int
     */
    public function getNombrePersonnes()
    {
        return $this->nombrePersonnes;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return CircuitProgramme
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set circuit
     *
     * @param \AppBundle\Entity\Circuit $circuit
     *
     * @return CircuitProgramme
     */
    public function setCircuit(\AppBundle\Entity\Circuit $circuit = null)
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * Get circuit
     *
     * @return \AppBundle\Entity\Circuit
     */
    public function getCircuit()
    {
        return $this->circuit;
    }
}
