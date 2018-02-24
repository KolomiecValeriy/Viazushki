<?php

namespace ViazushkiBundle\Controller\Api;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\Toy;

class ToyController extends FOSRestController
{
    /**
     * @param $id
     * @Rest\Get("/toy/{id}",
     *     name="api_get_toy"
     *     )
     * @return Response
     */
    public function getToyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $toy = $em->getRepository(Toy::class)->find($id);
        $context = new Context();
        $context->addGroup("toy");

        $view = $this->view($toy, 200);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
