<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class CategoryEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(name="category_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CostEntity", mappedBy="category_id", cascade={"all"}, orphanRemoval=true)
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank();
     */
    private $name;

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CategoryEntity
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
}
