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
}