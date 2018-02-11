<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="Likes")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\LikeRepository")
 * @UniqueEntity({"toy", "user"})
 */
class Like
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Toy", inversedBy="like", cascade={"persist"})
     * @ORM\JoinColumn(name="toy_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $toy;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="like", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Toy
     */
    public function getToy()
    {
        return $this->toy;
    }

    /**
     * @param Toy $toy
     *
     * @return $this
     */
    public function setToy(Toy $toy)
    {
        $this->toy = $toy;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
