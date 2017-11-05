<?php

namespace ViazushkiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Tag")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\TagRepository")
 */
class Tag
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
	 * One Tag have many Toys
	 * @ORM\OneToMany(targetEntity="Toy", mappedBy="tag")
     */
    private $toy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


    public function __construct()
	{
		$this->toy = new ArrayCollection();
	}

	/**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Tag
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
     * @param Toy $toy
     *
     * @return Tag
     */
    public function setToy(Toy $toy)
    {
        $this->toy[] = $toy;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getToys()
    {
        return $this->toy;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Tag
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
}

