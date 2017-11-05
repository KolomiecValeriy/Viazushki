<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="toy")
	 * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    private $tag;

    /**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="toy")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;


    public function __construct()
	{
		$this->image = new ArrayCollection();
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
     * @param Tag $tag
     *
     * @return Toy
     */
    public function setTag(Tag $tag)
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
        $this->image[] = $image;

        return $this;
    }

    /**
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->image;
    }

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @param mixed $updatedAt
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}
}
