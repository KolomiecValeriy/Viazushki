<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use ViazushkiBundle\Entity\Toy;

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
	 * Many Tag have many Toys
	 * @ORM\ManyToMany(targetEntity="Toy", mappedBy="tag", cascade={"persist"})
     * @ORM\JoinColumn(name="toys", onDelete="SET NULL")
     */
    private $toy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->toy = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add toy
     *
     * @param Toy $toy
     *
     * @return Tag
     */
    public function addToy(Toy $toy)
    {
        $this->toy[] = $toy;
        $toy->addTag($this);

        return $this;
    }

    /**
     * Remove toy
     *
     * @param Toy $toy
     */
    public function removeToy(Toy $toy)
    {
        $this->toy->removeElement($toy);
    }

    /**
     * Get toy
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToy()
    {
        return $this->toy;
    }
}
