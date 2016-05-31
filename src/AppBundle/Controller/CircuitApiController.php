<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Circuit;
use FOS\RestBundle\Controller\FOSRestController;

class CircuitApiController extends FOSRestController
{
        public function getCircuitsAction()
        {
                $em = $this->getDoctrine()->getManager();

                $data = $em->getRepository('AppBundle:Circuit')->findAll();
                $statusCode = 200;

                $view = $this->view($data, $statusCode);
                return $this->handleView($view);
        }


	public function getCircuitAction($id)
        {
                $em = $this->getDoctrine()->getManager();

                $circuit = $em->getRepository('AppBundle:Circuit')->find($id);

                if (!$circuit instanceof Circuit) {
                        throw new NotFoundHttpException('Circuit not found');
                }

                $view = $this->view($circuit, 200);
                return $this->handleView($view);
        }
}

