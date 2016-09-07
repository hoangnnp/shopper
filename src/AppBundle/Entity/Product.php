<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFeatured", type="boolean")
     */
    private $isFeatured;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     * @Gedmo\Translatable
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50)
     * @Gedmo\Translatable
     */
    private $state;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Product
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="products")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    public function getBrand()
{
    return $this->brand;
}
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="product")
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="SaleOff", inversedBy="products")
     * @ORM\JoinTable(name="SaleOff_Products")
     */
    private $saleoff;
    public function _contructor()
    {
        $this->saleoff = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->detailbills = new ArrayCollection();
    }
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    private $locale;

    /**
     * Set category
     *
     * @param string $name
     *
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
    public function setBrand($brand)
    {
        $this->brand =$brand;
        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->saleoff = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Product
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Add saleoff
     *
     * @param \AppBundle\Entity\SaleOff $saleoff
     *
     * @return Product
     */
    public function addSaleoff(\AppBundle\Entity\SaleOff $saleoff)
    {
        $this->saleoff[] = $saleoff;

        return $this;
    }

    /**
     * Remove saleoff
     *
     * @param \AppBundle\Entity\SaleOff $saleoff
     */
    public function removeSaleoff(\AppBundle\Entity\SaleOff $saleoff)
    {
        $this->saleoff->removeElement($saleoff);
    }

    /**
     * Get saleoff
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSaleoff()
    {
        return $this->saleoff;
    }

    /**
     * Set isFeatured
     *
     * @param boolean $isFeatured
     *
     * @return Product
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    /**
     * Get isFeatured
     *
     * @return boolean
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }
    /**
     * @ORM\OneToMany(targetEntity="detailbill", mappedBy="product")
     */
    private $detailbills;

    /**
     * Add detailbill
     *
     * @param \AppBundle\Entity\detailbill $detailbill
     *
     * @return Product
     */
    public function addDetailbill(\AppBundle\Entity\detailbill $detailbill)
    {
        $this->detailbills[] = $detailbill;

        return $this;
    }

    /**
     * Remove detailbill
     *
     * @param \AppBundle\Entity\detailbill $detailbill
     */
    public function removeDetailbill(\AppBundle\Entity\detailbill $detailbill)
    {
        $this->detailbills->removeElement($detailbill);
    }

    /**
     * Get detailbills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetailbills()
    {
        return $this->detailbills;
    }
}
