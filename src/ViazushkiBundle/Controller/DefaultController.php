<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction($tagId = '', $categoryId = '')
	{
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if ($tagId) $tag = $tagRepository->find($tagId);
        if ($categoryId) $category = $categoryRepository->find($categoryId);

        $toys = $toyRepository->findAll();
        if ($tagId) $toys = $toyRepository->findByTag($tag);
        if ($categoryId) $toys = $toyRepository->findByCategory($category);

		return $this->render('@Viazushki/Default/index.html.twig', [
		    'toys' => $toys,
		    'lastToys' => $toyRepository->findLastAdded(2),
		    'categories' => $categoryRepository->findAll(),
		    'tags' => $tagRepository->findAll(),
        ]);
	}
}
