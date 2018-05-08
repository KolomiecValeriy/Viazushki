<?php

namespace ViazushkiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\User;
use ViazushkiBundle\Form\Type\SearchType;
use ViazushkiBundle\Form\Type\SubscribeType;
use ViazushkiBundle\Form\Type\UnsubscribeType;

class SubscribeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function subscribeAction(Request $request)
    {
        $subscribeForm = $this->createForm(SubscribeType::class);

        $subscribeForm->handleRequest($request);
        $translator = $this->get('translator');
        if ($subscribeForm->isSubmitted() && $subscribeForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $user = $em->getRepository(User::class)->find($user);

            if ($user->isSubscribe()) {
                return new Response($translator->trans('already subscribed'), 200);
            }

            $user->setSubscribe(true);
            $user->setUnsubscribeKey($this->generateKey($user->getEmail(), $user->getSalt()));

            $em->flush();

            $sendSubscribeEmail = $this->get('viazushki.send_subscribe_email');
            $sendSubscribeEmail->sendSubscribe($user, 'Subscribe');

            return new Response($translator->trans('subscription completed'), 200);
        }

        return new Response('Subscription failed', 403);
    }

    /**
     * @param Request $request
     * @param string $unsubscribeKey
     * @return Response|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function unsubscribeAction(Request $request, $unsubscribeKey)
    {
        if (!$unsubscribeKey) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();

        $toyRepository = $em->getRepository('ViazushkiBundle:Toy');
        $categoryRepository = $em->getRepository('ViazushkiBundle:Category');

        $unsubscribeForm = $this->createForm(UnsubscribeType::class);
        $searchForm = $this->createForm(SearchType::class);

        $unsubscribeForm->handleRequest($request);
        if ($unsubscribeForm->isSubmitted() && $unsubscribeForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->finUserByUnsubscribeKey($unsubscribeKey);

            if (!$user) {
                throw $this->createNotFoundException();
            }

            if ($user->isSubscribe()) {
                $user->setSubscribe(false);
                $em->flush();
            }

            return $this->redirectToRoute('viazushki_homepage');
        }

        return $this->render('@Viazushki/Subscribe/unsubscribe.html.twig', [
            'unsubscribeKey' => $unsubscribeKey,
            'unsubscribeForm' => $unsubscribeForm->createView(),
            'searchForm' => $searchForm->createView(),
            'lastToys' => $toyRepository->findLastAdded($this->getLastAddedToys()),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @param string $firstString
     * @param string $secondString
     *
     * @return string
     */
    private function generateKey($firstString, $secondString) {
        return md5($firstString.$secondString);
    }

    private function getLastAddedToys()
    {
        return $this->container->getParameter('viazushki.last_added_toys');
    }
}
