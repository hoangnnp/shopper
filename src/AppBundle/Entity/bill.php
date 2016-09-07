<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\billRepository")
 */
class bill
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
     * @var float
     *
     * @ORM\Column(name="ordercost", type="float")
     */
    private $ordercost;

    /**
     * @var string
     *
     * @ORM\Column(name="orderstate", type="string", length=255)
     */
    private $orderstate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderdate", type="datetime")
     */
    private $orderdate;


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
     * Set ordercost
     *
     * @param float $ordercost
     *
     * @return bill
     */
    public function setOrdercost($ordercost)
    {
        $this->ordercost = $ordercost;

        return $this;
    }

    /**
     * Get ordercost
     *
     * @return float
     */
    public function getOrdercost()
    {
        return $this->ordercost;
    }

    /**
     * Set orderstate
     *
     * @param string $orderstate
     *
     * @return bill
     */
    public function setOrderstate($orderstate)
    {
        $this->orderstate = $orderstate;

        return $this;
    }

    /**
     * Get orderstate
     *
     * @return string
     */
    public function getOrderstate()
    {
        return $this->orderstate;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     *
     * @return bill
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="bills")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * @ORM\OneToMany(targetEntity="detailbill", mappedBy="bill")
     */
    private $detailbillss;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailbillss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return bill
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add detailbillss
     *
     * @param \AppBundle\Entity\detailbill $detailbillss
     *
     * @return bill
     */
    public function addDetailbillss(\AppBundle\Entity\detailbill $detailbillss)
    {
        $this->detailbillss[] = $detailbillss;

        return $this;
    }

    /**
     * Remove detailbillss
     *
     * @param \AppBundle\Entity\detailbill $detailbillss
     */
    public function removeDetailbillss(\AppBundle\Entity\detailbill $detailbillss)
    {
        $this->detailbillss->removeElement($detailbillss);
    }

    /**
     * Get detailbillss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetailbillss()
    {
        return $this->detailbillss;
    }
}
