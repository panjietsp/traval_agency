<?php
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Doctrine\ORM\Query\ResultSetMapping;

use AppBundle\Entity\Etape;

class AssocCircuitEtapeTest extends WebTestCase
{

	//const CIRCUIT = 'andalousie-circuit';
	const CIRCUIT = 'vietnam-circuit';
	const NBETAPES = 4;
	
	// Initialize a test database with circuits and etapes loaded
	public function setUp()
	{
		$this->fixtures = $this->loadFixtures([
				'AppBundle\DataFixtures\ORM\LoadCircuitData',
				'AppBundle\DataFixtures\ORM\LoadEtapeData'
		])->getReferenceRepository();
	}

	
	// normally there are 3 etapes
	public function testNbEtapes()
	{
		$circuit = $this->fixtures->getReference(AssocCircuitEtapeTest::CIRCUIT);
	
		//$this->assertEquals('Andalousie', $circuit->getDescription());
	
		$nbetapes = $circuit->getEtapes()->count();
		$this->assertEquals(AssocCircuitEtapeTest::NBETAPES, $nbetapes);
	}
	
	// Remove the etape #2 and save it
	// test with phpunit tests/AppBundle/Controller/AssocCircuitEtapeTest.php --filter 'AssocCircuitEtapeTest::testRemove$'
	public function testRemoveDB()
	{
		$em = $this->getContainer()->get('doctrine')->getManager();
		
		$query = $em->createQuery('SELECT COUNT(e.id) FROM AppBundle:Etape e');
		$nbtotaletapes = $query->getSingleScalarResult();
				
		$circuit = $this->fixtures->getReference(AssocCircuitEtapeTest::CIRCUIT);
		
		$etape = $em->getRepository('AppBundle:Etape')->findOneBy(array("circuit" => $circuit->getId(), "numeroEtape" => 2));
		$this->fixtures->getReference(AssocCircuitEtapeTest::CIRCUIT);
		
		$circuit->removeEtape($etape);
		
		$nbetapes = $circuit->getEtapes()->count();
		$this->assertEquals(AssocCircuitEtapeTest::NBETAPES-1, $nbetapes);
	
		$em->persist($circuit);
		$em->flush();
		
		$em->detach($circuit);
		unset($circuit);
		
		$circuit = $this->fixtures->getReference(AssocCircuitEtapeTest::CIRCUIT);
		$nbetapes = $circuit->getEtapes()->count();
		$this->assertEquals(AssocCircuitEtapeTest::NBETAPES-1, $nbetapes);
		
		
		$query = $em->createQuery('SELECT COUNT(e.id) FROM AppBundle:Etape e');
		$count = $query->getSingleScalarResult();
		
		$this->assertEquals($nbtotaletapes-1, $count);
	}
	
}