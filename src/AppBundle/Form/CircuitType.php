<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;

use AppBundle\Entity\Circuit;
use AppBundle\Form\CircuitType;

class CircuitType extends AbstractType
{
	
	
	public function postCircuitAction(Request $request)
	{
		$entity = new Circuit();
		$form = $this->createForm('\\AppBundle\\Form\\CircuitType', $entity);
		$form->handleRequest($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
	
			return $this->redirectView(
					$this->generateUrl(
							'api_1_get_circuit',
							array('id' => $entity->getId())
					),
					Codes::HTTP_CREATED
			);
		}
	
		dump($form->getErrors());
	
		$view = $this->view($form, 400);
	
		return $this->handleView($view);
	
	}
	
	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('paysDepart')
            ->add('villeDepart')
            ->add('villeArrivee')
            ->add('dureeCircuit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Circuit'
        ));
    }
}
