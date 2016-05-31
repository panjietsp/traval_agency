<?php

namespace AppBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\TextType;

use Doctrine\DBAL\Types\StringType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Circuit;
use AppBundle\Entity\Etape;
use Symfony\Component\HttpFoundation\Response;

class CircuitController extends Controller
{
        /**
         * @Route("/circuit/", name="zhuye")
         */
        public function indexAction()
        {
                $circuits = $this->getDoctrine()
                        ->getRepository('AppBundle:Circuit')
                        ->findAll();

                dump($circuits);
                return $this->render('circuit/index.html.twig', array( 'circuits' => $circuits));
        }

        /**
         * @Route("/circuit/{id}", name="circuit_show", requirements={
         *              "id": "\d+"
         *     })
         */
        public function showAction($id)
        {
                $circuit = $this->getDoctrine()
                        ->getRepository('AppBundle:Circuit')
                        ->find($id);
                if(!$circuit)
                {
                   throw $this->createNotFoundException('The circuit does not exist');
                }
                dump($circuit);
                return $this->render('circuit/circuit_show.html.twig', array(
                                'circuit' => $circuit));
        }


        /**
         * @Route("/admin/circuit/new", name="add_circuit")
         */
        public function newAction(Request $request)
        {
        	// ...
        	$circuit = new Circuit();
        	
        	$form = $this->createFormBuilder($circuit)
        	->add('description', TextType::class)
        	->add("paysDepart", TextType::class)
        	->add("villeDepart", TextType::class)
        	->add("villeArrivee", TextType::class)
        	->add('save', SubmitType::class, array('label' => 'Create circuit'))
        	->getForm();
        	
        	$form->handleRequest($request);
        	
        	if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		
        		$etape = new Etape();
        		$etape->setNumeroEtape(1);
        		$etape->setVilleEtape($circuit->getVilleDepart());
        		$etape->setNombreJours(2);
        		$circuit->addEtape($etape);
        		
        		$etape1 = new Etape();
        		$etape1->setNumeroEtape(2);
        		$etape1->setVilleEtape($circuit->getVilleArrivee());
        		$etape1->setNombreJours(2);
        		$circuit->addEtape($etape1);
        		
        		$em->persist($etape);
        		$em->persist($etape1);
        		$em->persist($circuit);
        		$em->flush();
        		
        		
        		
        		return $this->redirectToRoute('zhue', array( 'circuitId' => $circuit->getId()));
        		//return $this->render('etape/index.html.twig', array(
        		//		'circuit' => $circuit));
        	}
        	return $this->render('admin/circuit/new.html.twig', array(
        			'form' => $form->createView(),
        	));
        }
        
        
        /**
         * @Route("/admin/circuit/delete/{circuitId}", name="delete_circuit")
         */
        public function deleteAction($circuitId)
        {
        	// ...
        	$em = $this->getDoctrine()->getManager();
        	$circuit = $em->getRepository('AppBundle:Circuit')->find($circuitId);
			$em->remove($circuit);
	        $em->flush();
	        return $this->redirectToRoute('zhuye');
        }
}
