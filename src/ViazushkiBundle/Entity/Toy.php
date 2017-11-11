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
	 * @ORM\OneToMany(targetEntity="Image", mappedBy="toy", cascade={"remove"})
     */
    private $image;

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
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="toy", cascade={"persist"})
	 * @ORM\JoinTable(name="ToyTags")
     */
    private $tag;

    /**
     * Many Toys have one category
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="toys", cascade={"persist"})
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->tag = new ArrayCollection();
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
     * @return Toy
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
     * Set description
     *
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set author
     *
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
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createdAt
     *
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
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
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return Toy
     */
    public function addImage(Image $image)
    {
        $this->image[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \ViazushkiBundle\Entity\Image $image
     */
    public function removeImage(Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return Toy
     */
    public function addTag(Tag $tag)
    {
        $this->tag[] = $tag;
        $tag->addToy($this);

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set category
     *
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
     * Get category
     *
     * @return category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
