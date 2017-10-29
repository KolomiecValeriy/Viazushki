<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use ViazushkiBundle\Entity\Image;

/**
 * @ORM\Table(name="Toy")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\ToyRepository")
 */
class Toy
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="author", type="string", length=50, nullable=true)
     */
    private $author;

    /**
	 * One Toy have many Images
	 * @ORM\OneToMany(targetEntity="Image", mappedBy="toy", cascade={"remove"})
     */
    private $images;

    /**
	 * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="tag", type="integer", nullable=true)
     */
    private $tag;

    /**
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;


    public function __construct()
	{
		$this->images = new ArrayCollection();
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
     * @return Toy
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
     * @param string $description
     *
     * @return Toy
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $author
     *
     * @return Toy
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param integer $tag
     *
     * @return Toy
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return int
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param integer $category
     *
     * @return Toy
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

	/**
	 * @return int
	 */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Image $image
     *
     * @return Toy
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
