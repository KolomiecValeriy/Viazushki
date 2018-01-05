<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Form\Type\CommentType;

class CommentController extends Controller
{
    public function addAction(Request $request, $toyId)
    {
        if (!isset($toyId)) {
            return $this->redirectToRoute('viazushki_homepage');
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $toy = $em->getRepository('ViazushkiBundle:Toy')->find($toyId);

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

    public function editAction(Request $request, $commentId)
    {
        $em = $this->getDoctrine()->getManager();
        $commentRepository = $em->getRepository('ViazushkiBundle:Comment');
        $comment = $commentRepository->find($commentId);

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

        return new Response(
            $this->renderView('@Viazushki/Includes/_commentForm.html.twig', [
                'commentForm' => $commentForm->createView(),
                'commentId' => $comment->getId(),
            ])
        );
    }

    public function addChildAction(Request $request, $toyId, $parentId)
    {
        if (!isset($toyId) || !isset($parentId)) {
            return $this->redirectToRoute('viazushki_homepage');
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm[$parentId] = $this->createForm(CommentType::class, $comment);

        $commentRepository = $em->getRepository('ViazushkiBundle:Comment');
        $commentParent = $commentRepository->find($parentId);

        $toy = $em->getRepository('ViazushkiBundle:Toy')->find($toyId);

        $commentForm[$parentId]->handleRequest($request);
        if ($commentForm[$parentId]->isSubmitted() && $commentForm[$parentId]->isValid()) {

            $comment
                ->setMessage($commentForm[$parentId]->get('message')->getData())
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
}
