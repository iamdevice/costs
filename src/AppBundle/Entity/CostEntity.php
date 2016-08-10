<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CostRepository")
 * @ORM\Table(name="cost")
 */
class CostEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="cost_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cost_id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CategoryEntity", inversedBy="category_id")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category_id;

    /**
     * @ORM\Column(type="datetime", name="date_added")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $date_added;

    /**
     * @ORM\Column(type="float", name="money")
     * @Assert\NotBlank()
     */
    private $money;

    /**
     * Get cost_id
     *
     * @return integer
     */
    public function getCostId()
    {
        return $this->cost_id;
    }

    /**
     * Set date_added
     *
     * @param \DateTime $dateAdded
     * @return CostEntity
     */
    public function setDateAdded($dateAdded)
    {
        $this->date_added = $dateAdded;

        return $this;
    }

    /**
     * Get date_added
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * Set money
     *
     * @param float $money
     * @return CostEntity
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set category_id
     *
     * @param \AppBundle\Entity\CategoryEntity $categoryId
     * @return CostEntity
     */
    public function setCategoryId(\AppBundle\Entity\CategoryEntity $categoryId = null)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return \AppBundle\Entity\CategoryEntity
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }
}
