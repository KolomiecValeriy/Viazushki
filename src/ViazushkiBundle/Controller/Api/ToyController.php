<?php

namespace ViazushkiBundle\Controller\Api;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use ViazushkiBundle\Entity\Toy;

class ToyController extends FOSRestController
{
    /**
     * @param $id
     * @Rest\Get("/toys/{id}",
     *     name="api_get_toy"
     *     )
     * @SWG\Response(
     *     response=200,
     *     description="Return toy by id",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Toy::class, groups={"toy"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="This parameter used to get Toy"
     * )
     * @SWG\Tag(name="Toys")
     * @return Response
     */
    public function getToyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $toy = $em->getRepository(Toy::class)->find($id);

        if (!$toy) {
            return new Response($this->createNotFoundException('Toy with id - '.$id.' not found on this server!'));
        }

        $context = new Context();
        $context->addGroup("toy");

        $view = $this->view($toy, 200);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/toys",
     *     name="api_get_toys"
     *     )
     * @SWG\Response(
     *     response=200,
     *     description="Return all toys",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Toy::class, groups={"toy"})
     *     )
     * )
     * @SWG\Tag(name="Toys")
     * @return Response
     */
    public function getToysAction()
    {
        $em = $this->getDoctrine()->getManager();
        $toy = $em->getRepository(Toy::class)->findAll();
        $context = new Context();
        $context->addGroup("toy");

        $view = $this->view($toy, 200);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @param int $page
     * @param int $limit
     * @Rest\Get("/toys/{page}/{limit}",
     *     name="api_get_paginate_toys"
     *     )
     * @SWG\Response(
     *     response=200,
     *     description="Return paginate toys",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Toy::class, groups={"toy"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="path",
     *     type="string",
     *     description="This parameter used to set pagination page"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="path",
     *     type="string",
     *     description="This parameter used to set pagination limit"
     * )
     * @SWG\Tag(name="Toys")
     * @return Response
     */
    public function getPaginateToysAction($page = 1, $limit = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get("knp_paginator");

        $toy = $em->getRepository(Toy::class)->findAllQuery();
        $paginateToys = $paginator->paginate($toy, $page, $limit);

        if (count($paginateToys->getItems()) == 0) {
            return new Response($this->createNotFoundException('Toys not found!'));
        }

        $context = new Context();
        $context->addGroup("toy");

        $view = $this->view($paginateToys, 200);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
