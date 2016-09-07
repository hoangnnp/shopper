<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * detailbill
 *
 * @ORM\Table(name="detailbill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\detailbillRepository")
 */
class detailbill
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     *
     */
    private $quantity;

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return detailbill
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="detailbills")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\bill", inversedBy="detailbillss")
     * @ORM\JoinColumn(name="bill_id", referencedColumnName="id")
     */
    private $bill;

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return detailbill
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set bill
     *
     * @param \AppBundle\Entity\bill $bill
     *
     * @return detailbill
     */
    public function setBill(\AppBundle\Entity\bill $bill = null)
    {
        $this->bill = $bill;

        return $this;
    }
    /**
     * Get bill
     *
     * @return \AppBundle\Entity\bill
     */
    public function getBill()
    {
        return $this->bill;
    }
}
