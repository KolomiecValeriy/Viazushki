<?php

namespace ViazushkiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\UserRepository")
 * @ORM\Table(name="User")
 * @UniqueEntity("username", message="Пользователь с таким именем уже существует")
 * @UniqueEntity("email", message="Пользователь с таким Email уже существует")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Constraints\NotBlank(message="Имя не может быть пустым"))
     * @Constraints\Length(max="60", min="3", maxMessage="Имя не должно превышать 60 символов", minMessage="Имя должно быть больше 3-х символов")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Constraints\NotBlank(message="Email не может быть пустым")
     * @Constraints\Email(message="Вы допустили ошибку в email адрессе")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Constraints\NotBlank(message="Пароль не может быть пустым"))
     * @Constraints\Length(max="60", min="5", maxMessage="Пароль не должен превышать 60 символов", minMessage="Пероль должен быть больше 5-ти символов")
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="ViazushkiBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="ViazushkiBundle\Entity\Like", mappedBy="user")
     */
    private $like;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $subscribe;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $unsubscribeKey;

    public function __construct()
    {
        $this->isActive = true;
        $this->comments = new ArrayCollection();
        $this->like = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getUsername();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        return "trxVva7R52Vm";
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->getIsActive();
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    /**
     * @return ArrayCollection|Like[]
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * @param Like $like
     *
     * @return $this
     */
    public function addLike(Like $like)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * @param Like $like
     *
     * @return $this
     */
    public function removeLike(Like $like)
    {
        $this->like->removeElement($like);

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubscribe()
    {
        return $this->subscribe;
    }

    /**
     * @param bool $subscribe
     */
    public function setSubscribe(bool $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return string
     */
    public function getUnsubscribeKey()
    {
        return $this->unsubscribeKey;
    }

    /**
     * @param string $unsubscribeKey
     *
     * @return $this
     */
    public function setUnsubscribeKey($unsubscribeKey)
    {
        $this->unsubscribeKey = $unsubscribeKey;

        return $this;
    }
}
