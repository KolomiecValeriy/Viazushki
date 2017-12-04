<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use ViazushkiBundle\Entity\Tag;
use ViazushkiBundle\Entity\Category;
use ViazushkiBundle\Entity\Image;

/**
 * @ORM\Table(name="Toy")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\ToyRepository")
 */
class Toy
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=50, nullable=true)
     */
    private $author;

    /**
     * One Toy have many Images
     *
     * @ORM\OneToMany(targetEntity="ViazushkiBundle\Entity\Image", mappedBy="toy")
     */
    private $images;

    /**
     * One Toy have one main Image
     *
     * @ORM\OneToOne(targetEntity="ViazushkiBundle\Entity\Image")
     */
    private $mainImage;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Many Toys have many tags
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="toys", cascade={"persist"})
     * @ORM\JoinTable(name="ToyTags")
     */
    private $tags;

    /**
     * Many Toys have one category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="toys", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getName();
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
     * @param \DateTime $createdAt
     *
     * @return Toy
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
     * @param \DateTime $updatedAt
     *
     * @return Toy
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param Tag $tag
     *
     * @return Toy
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        $tag->addToy($this);

        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function removeTags(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Category $category
     *
     * @return Toy
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return ArrayCollection|Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Image $images
     *
     * @return Toy
     */
    public function setImages(Image $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return $mainImage
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param Image $mainImage
     *
     * @return Toy
     */
    public function setMainImage(Image $mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }
}
