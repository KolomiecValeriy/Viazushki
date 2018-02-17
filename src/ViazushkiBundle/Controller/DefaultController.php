<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Entity\Like;
use ViazushkiBundle\Entity\Tag;
use ViazushkiBundle\Entity\Toy;
use ViazushkiBundle\Form\Type\CommentType;
use ViazushkiBundle\Form\Type\LikeType;

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
            $this->getToysPerPage()
        );

        $likeForms = [];
        foreach ($toyRepository->findAll() as $toy) {
            $likeForms[$toy->getId()] = $this->createForm(LikeType::class)->createView();
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded($this->getLastAddedToys()),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
            'likeForms' => $likeForms,
        ]);
    }

    /**
     * @ParamConverter("toy", class="ViazushkiBundle:Toy")
     */
    public function showToyAction(Request $request, Toy $toy)
    {
        if (!$toy) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $likeForm = $this->createForm(LikeType::class);

        $categories = $em->getRepository('ViazushkiBundle:Category')->findAll();
        $tags = $em->getRepository('ViazushkiBundle:Tag')->findAll();
        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');

        $commentRepository = $em->getRepository('ViazushkiBundle:Comment');
        $paginator = $this->get('knp_paginator');
        $commentPagination = $paginator->paginate(
            $commentRepository->finByToyQuery($toy),
            $request->query->getInt('page', 1),
            $this->getCommentsPerPage()
        );

        $commentsForms = [];
        foreach ($toy->getComments() as $comm) {
            $commentsForms[$comm->getId()] = $this->createForm(CommentType::class, $comment)->createView();
        }

        $commentForm->handleRequest($request);
        return $this->render('@Viazushki/Default/showToy.html.twig', [
            'toy' => $toy,
            'lastToys' => $toyRepository->findLastAdded($this->getLastAddedToys()),
            'categories' => $categories,
            'tags' => $tags,
            'commentForm' => $commentForm->createView(),
            'commentsForms' => $commentsForms,
            'commentPagination' => $commentPagination,
            'likeForm' => $likeForm->createView(),
        ]);
    }

    /**
     * @ParamConverter("tag", class="ViazushkiBundle:Tag")
     */
    public function toyByTagAction(Request $request, Tag $tag)
    {
        if (!$tag) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$toys = $toyRepository->findByTag($tag)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $likeForms = [];
        foreach ($toyRepository->findAll() as $toy) {
            $likeForms[$toy->getId()] = $this->createForm(LikeType::class)->createView();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $toys,
            $request->query->getInt('page', 1),
            $this->getToysPerPage()
        );

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded($this->getLastAddedToys()),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
            'likeForms' => $likeForms,
        ]);
    }

    /**
     * @ParamConverter("category", class="ViazushkiBundle:Category")
     */
    public function toyByCategoryAction(Request $request, Category $category)
    {
        if (!$category) {
            throw new NotFoundHttpException("Страница не найдена");
        }

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
            $this->getToysPerPage()
        );

        $likeForms = [];
        foreach ($toyRepository->findAll() as $toy) {
            $likeForms[$toy->getId()] = $this->createForm(LikeType::class)->createView();
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'pagination' => $pagination,
            'lastToys' => $toyRepository->findLastAdded($this->getLastAddedToys()),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
            'likeForms' => $likeForms,
        ]);
    }

    private function getCommentsPerPage()
    {
        return $this->container->getParameter('viazushki.comments_per_page');
    }

    private function getToysPerPage()
    {
        return $this->container->getParameter('viazushki.toys_per_page');
    }

    private function getLastAddedToys()
    {
        return $this->container->getParameter('viazushki.last_added_toys');
    }
}
