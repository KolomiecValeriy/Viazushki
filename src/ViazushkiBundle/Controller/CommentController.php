<?php

namespace ViazushkiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Entity\Toy;
use ViazushkiBundle\Form\Type\CommentType;

class CommentController extends Controller
{

    /**
     * @ParamConverter("toy", class="ViazushkiBundle:Toy")
     */
    public function addAction(Request $request, Toy $toy)
    {
        if (!$toy) {
            return new Response(
                $this->get('translator')->trans('comment not added'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment
                ->setMessage($commentForm->get('message')->getData())
                ->setToy($toy)
                ->setUser($this->getUser());

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('viazushki_toy', [
                'slug' => $toy->getSlug(),
            ]);
        }

        return $this->forward('ViazushkiBundle:Default:showToy', [
            'toy' => $toy,
        ]);
    }

    /**
     * @ParamConverter("comment", class="ViazushkiBundle:Comment")
     */
    public function editAction(Request $request, $comment)
    {
        if (!$comment) {
            return new Response(
                $this->get('translator')->trans('comment not updated'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('edit', $comment);

        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment
                ->setMessage($commentForm->get('message')->getData())
            ;
            $em->flush();

            return $this->redirectToRoute('viazushki_toy', [
                'slug' => $comment->getToy()->getSlug(),
            ]);
        }

        return $this->render('@Viazushki/Includes/_commentForm.html.twig', [
                'commentForm' => $commentForm->createView(),
                'commentId' => $comment->getId(),
            ]
        );
    }

    /**
     * @ParamConverter("toy", class="ViazushkiBundle:Toy")
     * @ParamConverter("commentParent", class="ViazushkiBundle:Comment")
     */
    public function addChildAction(Request $request, $toy, $commentParent)
    {
        if (!$toy || !$commentParent) {
            return new Response(
                $this->get('translator')->trans('comment not added'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm[$commentParent->getId()] = $this->createForm(CommentType::class, $comment);

        $commentForm[$commentParent->getId()]->handleRequest($request);
        if ($commentForm[$commentParent->getId()]->isSubmitted() && $commentForm[$commentParent->getId()]->isValid()) {

            $comment
                ->setMessage($commentForm[$commentParent->getId()]->get('message')->getData())
                ->setToy($toy)
                ->setUser($this->getUser())
                ->setParent($commentParent)
            ;

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('viazushki_toy', [
                'slug' => $toy->getSlug(),
            ]);
        }

        return $this->forward('ViazushkiBundle:Default:showToy', [
            'toy' => $toy,
        ]);
    }

    /**
     * @ParamConverter("comment", class="ViazushkiBundle:Comment")
     */
    public function deleteAction($comment)
    {
        if (!$comment) {
            return new Response(
                $this->get('translator')->trans('comment not deleted'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();

        if (!$this->isGranted('ROLE_ADMIN', $comment)) {
            throw $this->createAccessDeniedException();
        }

        $toy = $comment->getToy();

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('viazushki_toy', [
            'slug' => $toy->getSlug(),
        ]);


    }
}
