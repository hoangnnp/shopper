<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SaleOff
 *
 * @ORM\Table(name="sale_off")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleOffRepository")
 */
class SaleOff
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="startdate", type="date")
     */
    private $startdate;

    /**
     * @var string
     *
     * @ORM\Column(name="daysfinish", type="date")
     */
    private $daysfinish;
    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="float", length=255)
     */
    private $operation;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SaleOff
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set operation
     *
     * @param string $operation
     *
     * @return SaleOff
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return string
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set startdate
     *
     * @param string $startdate
     *
     * @return SaleOff
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate()
    {
        return $this->enddate;
    }


    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return SaleOff
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
     * Set image
     *
     * @param string $image
     *
     * @return SaleOff
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="saleoff")
     */
    private $products;

    public function  _contructor()
    {
        $this->products = new ArrayCollection();
    }
}

