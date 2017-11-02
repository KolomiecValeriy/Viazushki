<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\Image;
use ViazushkiBundle\Entity\Toy;

class ToyController extends Controller
{
    public function addToyAction()
    {
        $em = $this->getDoctrine()->getManager();

        $image = new Image();
        $image->setName('First Image name');
        $image->setSrc('some src path');
        $image->setType('type');
        $image->setMain(true);

        $image2 = new Image();
        $image2->setName('Second Image name');
        $image2->setSrc('some src path');
        $image2->setType('type');
        $image2->setMain(true);

        $toy = new Toy();
        $toy->setName('Toy name - '.$toy->getId());
        $toy->setAuthor('Some toy author');
        $toy->setDescription('Some description about this toy');

        $image->setToy($toy);
        $image2->setToy($toy);

        $em->persist($image);
        $em->persist($image2);
        $em->flush();

        return new Response(
            'Seve new Toy with id: ' . $toy->getId()
            .'<br>Seve new Image with id: ' . $image->getId()
        );
    }

    public function showToyAction($toyId)
    {
        $em = $this->getDoctrine()->getManager();

        $toy = $em->getRepository('ViazushkiBundle:Toy')
            ->find($toyId);
        $images = $toy->getImages();

        return $this->render(
            'ViazushkiBundle::toy.html.twig',
            [
                'toy' => $toy,
                'images' => $images,
            ]
        );
    }

    public function updateToyAction($toyId)
    {
        $em = $this->getDoctrine()->getManager();

        $toy = $em->getRepository('ViazushkiBundle:Toy')
            ->find($toyId);

        $toy->setName('New Toy name');
        $em->flush();

        return $this->redirectToRoute(
            'viazushki_show_toy',
            [
                'toyId' => $toyId,
            ]
        );
    }

    public function deleteToyAction($toyId)
    {
        $em = $this->getDoctrine()->getManager();

        $toy = $em->getRepository('ViazushkiBundle:Toy')
            ->find($toyId);

        $em->remove($toy);
        $em->flush();

        return new Response('Toy with id: \''.$toyId.'\' was successfully deleted with her images.');
    }
}
