<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Circuit;
use AppBundle\Entity\Etape;

class CircuitTest extends \PHPUnit_Framework_TestCase
{
	public function testDureeCircuit()
	{
		$circuit = new Circuit();
		
		$circuit->setDescription('Andalousie');
		$circuit->setPaysDepart('Espagne');
		$circuit->setVilleDepart('Grenade');
		$circuit->setVilleArrivee('Séville');
		//$circuit->setDureeCircuit(42);
		
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Grenade");
		$etape->setNombreJours(2);
		$etape->setCircuit($circuit);
		
		$circuit->addEtape($etape);
		
		$this->assertEquals(2, $circuit->getDureeCircuit());
	}
}