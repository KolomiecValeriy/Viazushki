<?php

namespace ViazushkiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="src", type="string", length=255, nullable=true)
     */
    private $src;

    /**
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
	 * Many Images have one Toy
     * @ORM\ManyToOne(targetEntity="Toy", inversedBy="image", cascade={"persist"})
	 * @ORM\JoinColumn(name="toy_id", referencedColumnName="id")
     */
    private $toy;

    /**
     * @ORM\Column(name="main", type="boolean", nullable=true)
     */
    private $main;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


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
     * @return Image
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
     * @param string $src
     *
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $type
     *
     * @return Image
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $main
     *
     * @return Image
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return bool
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param Toy $toy
     *
     * @return Image
     */
    public function setToy(Toy $toy = null)
    {
        $this->toy = $toy;

        return $this;
    }

    /**
     * @return Toy
     */
    public function getToy()
    {
        return $this->toy;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
