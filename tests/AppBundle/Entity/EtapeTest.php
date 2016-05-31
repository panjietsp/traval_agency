<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Circuit;
use AppBundle\Entity\Etape;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EtapeTest extends KernelTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * {@inheritDoc}
	 */
	protected function setUp()
	{
		self::bootKernel();
	
		$this->em = static::$kernel->getContainer()
		->get('doctrine')
		->getManager();
	}
	
	public function testCircuitOneToManyEtapes()
	{
		$circuit = new Circuit();
		
		$circuit->setDescription('Andalousie');
		$circuit->setPaysDepart('Espagne');
		$circuit->setVilleDepart('Grenade');
		$circuit->setVilleArrivee('SÃ©ville');
		
		$etape1 = new Etape();
		$etape1->setNumeroEtape(1);
		$etape1->setVilleEtape("Grenade");
		$etape1->setNombreJours(2);
		
		$circuit->addEtape($etape1);

		$etape2 = new Etape();
		$etape2->setNumeroEtape(2);
		$etape2->setVilleEtape("Cordoue");
		$etape2->setNombreJours(1);
		
		$circuit->addEtape($etape2);
		
		$this->assertEquals(2, $circuit->getEtapes()->count());
		
		$this->assertNotNull($etape2->getCircuit());
		
		$this->assertEquals($etape1->getCircuit()->getId(), $etape2->getCircuit()->getId());
	}

	public function testAssociationCircuitEtapes()
	{
		//$circuit = $this->fixtures->getReference(CircuitControllerTest::CIRCUIT);
		$circuit = $this->em->getRepository('AppBundle:Circuit')->find(2);
	
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Nouvelle");
		$etape->setNombreJours(2);
	
		//$etape->setCircuit($circuit);
	
		$circuit->addEtape($etape);
	
		//$em = $this->getContainer()->get('doctrine')->getManager();
		$this->em->persist($etape);
		$this->em->flush();
	
		$etapeid = $etape->getId();
		$circuitid = $circuit->getId();
	
		//$this->em->detach($circuit);
		//unset($circuit);
	
		$this->em->detach($etape);
		unset($etape);
	
		//$etape = $this->em->getRepository('AppBundle:Etape')->find($etapeid);
	
		//$this->assertEquals($circuitid, $etape->getCircuit()->getId());
		
		$result = $this->em->createQuery("SELECT e FROM AppBundle:Etape e ".
				"WHERE e.circuit = :circuit")
				->setParameter("circuit", $circuit)
				->getResult();
		
		$this->assertNotEmpty($result);
		
		$this->assertEquals($circuitid, $result[0]->getCircuit()->getId());
	
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		parent::tearDown();
	
		$this->em->close();
	}
}
