<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
