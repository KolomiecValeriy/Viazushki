<?php

namespace ViazushkiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Tag;

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

    /**
     * @ParamConverter("tag", class="ViazushkiBundle:Tag")
     */
    public function toyByTagAction(Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$tag = $toyRepository->findByTag($tag)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'toys' => $tag,
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @ParamConverter("category", class="ViazushkiBundle:Category")
     */
    public function toyByCategoryAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $tagRepository = $em->getRepository('ViazushkiBundle:Tag');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        if (!$category = $toyRepository->findByCategory($category)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('@Viazushki/Default/index.html.twig', [
            'toys' => $category,
            'lastToys' => $toyRepository->findLastAdded(2),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll(),
        ]);
    }
}
