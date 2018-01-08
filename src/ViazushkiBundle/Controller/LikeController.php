<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ViazushkiBundle\Entity\Like;

class LikeController extends Controller
{
    public function addAction($toyId)
    {
        $em = $this->getDoctrine()->getManager();

        $toy = $em->getRepository('ViazushkiBundle:Toy')->find($toyId);
        if (!$toy) {
            throw $this->createNotFoundException();
        }
        $like = new Like();

        $like
            ->setUser($this->getUser())
            ->setToy($toy)
        ;

        $em->persist($like);
        $em->flush();

        return $this->redirectToRoute('viazushki_homepage');
    }

    public function deleteAction($toyId)
    {
        $em = $this->getDoctrine()->getManager();

        $toy = $em->getRepository('ViazushkiBundle:Toy')->find($toyId);
        if (!$toy) {
            throw $this->createNotFoundException();
        }
        $likes = $em->getRepository('ViazushkiBundle:Like')->findBy(['toy' => $toy->getId(), 'user' => $this->getUser()]);

        foreach ($likes as $like) {
            $em->remove($like);
        }
        $em->flush();

        return $this->redirectToRoute('viazushki_homepage');
    }
}
