<?php

namespace ViazushkiBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use ViazushkiBundle\Entity\Toy;

/**
 * @ORM\Table(name="Category")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
	 * One Category have many Toys
	 * @ORM\OneToMany(targetEntity="Toy", mappedBy="category")
     */
    private $toys;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->toys = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param Toy $toy
     *
     * @return Category
     */
    public function addToys(Toy $toy)
    {
        $this->toys[] = $toy;

        return $this;
    }

    /**
     * @param Toy $toy
     *
     * @return $this
     */
    public function removeToy(Toy $toy)
    {
        $this->toys->removeElement($toy);

        return $this;
    }

    /**
     * @return Collection|Toy[]
     */
    public function getToys()
    {
        return $this->toys;
    }
}
