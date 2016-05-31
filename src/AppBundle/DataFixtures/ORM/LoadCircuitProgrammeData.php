<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CircuitProgramme;

class LoadCircuitProgrammeData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$circuitprogramme = new CircuitProgramme();
		$circuitprogramme->setDateDepart(new \DateTime('2013-07-10'));
		$circuitprogramme->setNombrePersonnes(10);
		$circuitprogramme->setPrix(850);
		$circuitprogramme->setCircuit($this->getReference('andalousie-circuit'));
		
		$manager->persist($circuitprogramme);

		$this->addReference('programmation-andalousie-1', $circuitprogramme);
		
		$circuitprogramme = new CircuitProgramme();
		$circuitprogramme->setDateDepart(new \DateTime('2013-08-10'));
		$circuitprogramme->setNombrePersonnes(10);
		$circuitprogramme->setPrix(1500);
		$circuitprogramme->setCircuit($this->getReference('vietnam-circuit'));
		
		$manager->persist($circuitprogramme);
		
		$this->addReference('programmation-vietnam-1', $circuitprogramme);
		
		$circuitprogramme = new CircuitProgramme();
		$circuitprogramme->setDateDepart(new \DateTime('2013-05-15'));
		$circuitprogramme->setNombrePersonnes(12);
		$circuitprogramme->setPrix(120);
		$circuitprogramme->setCircuit($this->getReference('idf-circuit'));
		
		$manager->persist($circuitprogramme);
		
		$this->addReference('programmation-idf-1', $circuitprogramme);
		
		$circuitprogramme = new CircuitProgramme();
		$circuitprogramme->setDateDepart(new \DateTime('2013-10-23'));
		$circuitprogramme->setNombrePersonnes(15);
		$circuitprogramme->setPrix(1100);
		$circuitprogramme->setCircuit($this->getReference('italie-circuit'));
		
		$manager->persist($circuitprogramme);
		
		$this->addReference('programmation-italie-1', $circuitprogramme);
		
		$manager->flush();
	}

	public function getOrder()
	{
		// the order in which fixtures will be loaded
		// the lower the number, the sooner that this fixture is loaded
		return 2;
	}
}

// (1, 1, '2013-07-10', 10, 850),
// (2, 2, '2013-08-10', 10, 1500),
// (3, 3, '2013-05-15', 12, 120),
// (4, 4, '2013-10-23', 15, 1100);

