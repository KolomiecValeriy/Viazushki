<?php

namespace ViazushkiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ViazushkiBundle\Entity\User;
use ViazushkiBundle\Form\Type\SubscribeType;

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

            $em->flush();

            $sendSubscribeEmail = $this->get('viazushki.send_subscribe_email');
            $sendSubscribeEmail->sendSubscribe($user, 'Subscribe');

            return new Response($translator->trans('subscription completed'), 200);
        }

        return new Response('Subscription failed', 403);
    }
}
