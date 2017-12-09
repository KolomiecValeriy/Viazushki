<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        return $this->render('@Viazushki/Default/index.html.twig', [
            'toys' => $toyRepository->findAll(),
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    public function toyByTagAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$tag = $tagRepository->findBySlug($slug)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'toys' => $toyRepository->findByTag($tag),
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    public function toyByCategoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$category = $categoryRepository->findBySlug($slug)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'toys' => $toyRepository->findByCategory($category),
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }
}
