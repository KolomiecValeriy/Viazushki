<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Tag;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $toyRepository->findAllQuery(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @ParamConverter("tag", class="ViazushkiBundle:Tag")
     */
    public function toyByTagAction(Request $request, Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$toys = $toyRepository->findByTag($tag)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $toys,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @ParamConverter("category", class="ViazushkiBundle:Category")
     */
    public function toyByCategoryAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$toys = $toyRepository->findByCategory($category)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $toys,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }
}
