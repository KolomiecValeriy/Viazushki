<?php

namespace ViazushkiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ViazushkiBundle\Entity\Like;
use ViazushkiBundle\Entity\Toy;
use ViazushkiBundle\Form\Type\LikeType;

class LikeController extends Controller
{
    /**
     * @ParamConverter("toy", class="ViazushkiBundle:Toy")
     */
    public function updateAction(Request $request, Toy $toy)
    {
        if (!$toy) {
            throw $this->createNotFoundException('Страница не найдена');
        }

        $em = $this->getDoctrine()->getManager();

        $like = new Like();
        $likeForm = $this->createForm(LikeType::class);
        $currentUser = $this->getUser();

        $likeForm->handleRequest($request);
        if ($likeForm->isSubmitted() && $likeForm->isValid()) {
            $like
                ->setToy($toy)
                ->setUser($currentUser)
            ;

            if (count($this->get('validator')->validate($like)) == 0) {
                $em->persist($like);
                $em->flush();
            } else {
                $like = $em->getRepository('ViazushkiBundle:Like')->findOneBy([
                   'toy' => $toy,
                   'user' => $currentUser,
                ]);

                $em->remove($like);
                $em->flush();
            }
            return $this->redirectToRoute('viazushki_toy', ['slug' => $toy->getSlug()]);
        }

        return $this->createNotFoundException('Страница не найдена');
    }
}
