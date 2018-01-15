<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Entity\Tag;
use ViazushkiBundle\Entity\Toy;
use ViazushkiBundle\Form\Type\CommentType;

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
            'lastToys' => $toyRepository->findLastAdded(5),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @ParamConverter("toy", class="ViazushkiBundle:Toy")
     */
    public function showToyAction(Request $request, Toy $toy)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $categories = $em->getRepository('ViazushkiBundle:Category')->findAll();
        $tags = $em->getRepository('ViazushkiBundle:Tag')->findAll();
        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $toy = $toyRepository->find($toy);

        $commentRepository = $em->getRepository('ViazushkiBundle:Comment');
        $paginator = $this->get('knp_paginator');
        $commentPagination = $paginator->paginate(
            $commentRepository->finByToyQuery($toy),
            $request->query->getInt('page', 1),
            5
        );

        $commentsForms = [];
        foreach ($toy->getComments() as $comm) {
            $commentsForms[$comm->getId()] = $this->createForm(CommentType::class, $comment)->createView();
        }

        $commentForm->handleRequest($request);
        return $this->render('@Viazushki/Default/showToy.html.twig', [
            'toy' => $toy,
            'lastToys' => $toyRepository->findLastAdded(5),
            'categories' => $categories,
            'tags' => $tags,
            'commentForm' => $commentForm->createView(),
            'commentsForms' => $commentsForms,
            'commentPagination' => $commentPagination,
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
