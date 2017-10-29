<?php

namespace ViazushkiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\Image;

class ImageController extends Controller
{
	public function addImageAction($toyId)
	{
		$em = $this->getDoctrine()->getManager();

		$toy = $em->getRepository('ViazushkiBundle:Toy')
			->find($toyId);

		$image = new Image();
		$image->setName('New image from Image Controller');
		$image->setType('jpg');
		$image->setSrc('/some src/');
		$image->setToy($toy);
		$image->setMain(false);

		$em->persist($image);
		$em->flush();

		return new Response('Added image for toy: ' . $toy->getName());
	}

	public function showImageAction($imageId)
	{
		$em = $this->getDoctrine()->getManager();

		$image = $em->getRepository('ViazushkiBundle:Image')
			->find($imageId);

		return $this->render('ViazushkiBundle::image.html.twig',
			[
				'image' => $image,
			]
		);
	}

	public function updateImageAction($imageId)
	{
		$em = $this->getDoctrine()->getManager();

		$image = $em->getRepository('ViazushkiBundle:Image')
			->find($imageId);
		$image->setName('Update image from Image Controller');
		$image->setType('gif');
		$image->setSrc('/some src/');
		$image->setMain(false);

		$em->flush();

		return $this->redirectToRoute('viazushki_show_image',
			[
				'imageId' => $imageId,
			]
		);
	}

	public function deleteImageAction($imageId)
	{
		$em = $this->getDoctrine()->getManager();

		$imge = $em->getRepository('ViazushkiBundle:Image')
			->find($imageId);

		$em->remove($imge);
		$em->flush();

		return new Response('Image with id: \''.$imageId.'\' was successfully deleted.');
	}
}
