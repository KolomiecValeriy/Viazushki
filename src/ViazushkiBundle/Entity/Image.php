<?php

namespace ViazushkiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints;

/**
 * @ORM\Table(name="Image")
 * @ORM\Entity(repositoryClass="ViazushkiBundle\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $imagePath;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var array
     */
    private $files;

    /**
     * @ORM\ManyToMany(targetEntity="Toy", mappedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="toys", onDelete="SET NULL")
     */
    private $toys;

    public function __construct()
    {
        $this->toys = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getImageName();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $imageName
     *
     * @return Image
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param integer $mimeType
     *
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     *
     * @return Image
     */
    public function setImagePath(string $imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @param Toy $toy
     *
     * @return Image
     */
    public function addToy(Toy $toy)
    {
        $this->toys[] = $toy;

        return $this;
    }

    /**
     * @param Toy $toy
     */
    public function removeToy(Toy $toy)
    {
        $this->toys->removeElement($toy);
    }

    /**
     * @return ArrayCollection|Toy[]
     */
    public function getToys()
    {
        return $this->toys;
    }

}
