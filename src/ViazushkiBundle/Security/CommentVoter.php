<?php

namespace ViazushkiBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use ViazushkiBundle\Entity\Comment;
use ViazushkiBundle\Entity\User;

class CommentVoter extends Voter
{
    const EDIT = 'edit';

    private $decisionManager;
    private $commentEditTime;

    public function __construct(AccessDecisionManagerInterface $decisionManager, $commentEditTime)
    {
        $this->decisionManager = $decisionManager;
        $this->commentEditTime = $commentEditTime;
    }

    protected function supports($attribute, $subject)
    {
        if ($attribute != self::EDIT) {
            return false;
        }

        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $comment = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($comment, $user, $this->commentEditTime);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Comment $comment, User $user, $commentEditTime)
    {
        $now = new \DateTime();
        $time = $now->getTimestamp() - $comment->getCreatedAt()->getTimestamp();

        if ($time < $commentEditTime && $user == $comment->getUser()) {
            return true;
        } else {
            return false;
        }
    }
}
