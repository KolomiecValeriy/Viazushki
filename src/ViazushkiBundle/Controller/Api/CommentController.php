<?php

namespace ViazushkiBundle\Controller\Api;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Entity\Toy;

class CommentController extends FOSRestController
{
    /**
     * @param Toy $id
     * @param int $page
     * @param int $limit
     *
     * @Rest\Get("/toys/{id}/comments/{page}/{limit}",
     *     name="api_get_comments"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return paginate comments for toy",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Comment::class, groups={"comment"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="This parameter used to set Toy"
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
     * @SWG\Tag(name="Comments")
     * @return Response
     */
    public function getCommentsAction(Toy $id, $page = 1, $limit = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $toy = $em->getRepository(Toy::class)->find($id);
        if (!$toy) {
            return new Response($this->createNotFoundException('Toy with id - '.$id.' not found on this server!'));
        }

        $comments = $em->getRepository(Comment::class)->finByToyQuery($toy);
        if (!$comments) {
            return new Response($this->createNotFoundException('Comments not found!'));
        }

        $paginator = $this->get("knp_paginator");
        $paginatedComments = $paginator->paginate(
            $comments,
            (int) $page,
            (int) $limit
        );

        $context = new Context();
        $context->addGroup("comment");

        $view = $this->view($paginatedComments, 200);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Toy $id
     *
     * @Rest\Post("/toys/{id}/comments",
     *     name="api_post_comments"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="This parameter used to set Toy"
     * )
     * @SWG\Parameter(
     *     name="message",
     *     in="body",
     *     type="string",
     *     description="Message for comment",
     *     @SWG\Schema(
     *         @Model(type=Comment::class, groups={"comment"})
     *     )
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return ok",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Comment::class, groups={"comment"})
     *     )
     * )
     * @return Response
     */
    public function postCommentAction(Request $request, Toy $id)
    {
        $em = $this->getDoctrine()->getManager();

        $serializer = $this->get('serializer');
        $validator = $this->get('validator');

        $body = $serializer->decode($request->getContent(), 'json');

        foreach ($body as $commentRequest) {
            $comment = new Comment();
            $comment
                ->setMessage($commentRequest['message'])
                ->setToy($id)
                ->setUser($this->getUser())
            ;
            $violations = $validator->validate($comment);

            if (count($violations) > 0) {
                return new Response($violations->get(0)->getMessage(), 403);
            }

            $em->persist($comment);
        }
        $em->flush();

        return new Response('ok');
    }
}
