<?php

namespace Enguys\CoreBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface TreeInterface
{
    public function getWeight(): int;

    public function setWeight(int $weight);

    public function getLevel(): int;

    public function setLevel(int $level);

    public function getParent(): ?TreeInterface;

    public function setParent(?TreeInterface $parent);

    public function getChildren(): Collection;

    public function addChild(TreeInterface $item);

    public function removeChild(TreeInterface $item);

    public function __toString(): string;
}
