<?php

namespace Enguys\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

abstract class Tree implements TreeInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $weight;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @var Tree
     * @ORM\ManyToOne(targetEntity="Tree", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Tree", mappedBy="parent")
     * @ORM\OrderBy({"weight" = "ASC"})
     */
    protected $children;

    public function __construct()
    {
        $this->weight = 0;
        $this->level = 0;
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
        $children = $this->getChildren();
        if (!$children->isEmpty()) {
            /** @var \Enguys\CoreBundle\Entity\TreeInterface $child */
            foreach ($children as $child) {
                $child->setLevel($this->level + 1);
            }
        }
    }

    /**
     * @return \Enguys\CoreBundle\Entity\TreeInterface|null
     */
    public function getParent(): ?TreeInterface
    {
        return $this->parent;
    }

    /**
     * @param \Enguys\CoreBundle\Entity\TreeInterface|null $parent
     */
    public function setParent(?TreeInterface $parent)
    {
        $this->parent = $parent;
        if ($this->parent) {
            $this->setLevel($this->parent->getLevel() + 1);
        }
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(TreeInterface $item)
    {
        $this->children->add($item);
        $item->setParent($this);
    }

    public function removeChild(TreeInterface $item)
    {
        $this->children->removeElement($item);
    }
}
