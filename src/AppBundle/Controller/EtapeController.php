<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Doctrine\DBAL\Types\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Circuit;
use AppBundle\Entity\Etape;
use Symfony\Component\HttpFoundation\Response;

class EtapeController extends Controller
{
        /**
         * @Route("/etape/{circuitId}", name="zhue")
         */
        public function indexAction($circuitId)
        {
                $circuit = $this->getDoctrine()
                        ->getRepository('AppBundle:Circuit')
                        ->find($circuitId);

                dump($circuit);
               $liste = new array();
                return $this->render('etape/index.html.twig', array(
                                'circuit' => $circuit));
        }

      

        
       /**
         * @Route("/admin/etape/new/{circuitId}", name = "add_etape")
         */
        public function newAction($circuitId, Request $request)
        {
        	// ...
        	$circuit = $this->getDoctrine()
        	->getRepository('AppBundle:Circuit')
        	->find($circuitId);
        	
        	$a=$circuit->getEtapes()->count();
        	$etape = new Etape();
        	$etape->setNombreJours(2);
        	$etape->setNumeroEtape($a);
        	$circuit->getEtapes()->last()->setNumeroEtape($a+1);
        	
        	$form = $this->createFormBuilder($etape)
        	->add('numeroEtape', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class)
		    ->add('villeEtape', TextareaType::class)
			->add('nombreJours', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class)
        	->add('save', SubmitType::class, array('label' => 'Create etape'))
        	->getForm();
        	
        	$form->handleRequest($request);
        	
        	if ($form->isSubmitted() && $form->isValid()) {
        		$circuit->addEtape($etape);
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($etape);
        		$em->flush();
        		return $this->redirectToRoute( 'zhue', array( 'circuitId' => $circuit->getId()));
        	}
        	
        	return $this->render('admin/etape/new.html.twig', array(
        			'form' => $form->createView(), 
        			"circuitId"=>$circuitId
        	));
        }
        
        /**
         * @Route("/admin/etape/delete/{circuitId}/{etapeId}", name = "delete_etape")
         */
        public function deleteAction($circuitId, $etapeId)
        {
        	// ...
        	$em = $this->getDoctrine()->getManager();
        	$circuit = $em->getRepository('AppBundle:Circuit')->find($circuitId);
        	//$circuit = $this->getDoctrine()
        	//->getRepository('AppBundle:Circuit')
        	//->find($circuitId);
        
        	foreach( $circuit->getEtapes() as $etap )
        	{
        		if($etapeId==$etap->getId())
        		{
        			$circuit->removeEtape($etap);
        			$em->remove($etap);
				$em->flush();
        		}
        	}
        
        	return $this->redirectToRoute('zhue', array( 'circuitId' => $circuit->getId()));
        
        }
        
       
}
