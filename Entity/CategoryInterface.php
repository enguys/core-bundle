<?php

namespace Enguys\CoreBundle\Entity;

interface CategoryInterface extends TreeInterface
{
    public function getId(): string;

    public function getName(): ?string;

    public function setName(?string $name);

    public function getSlug(): ?string;

    public function getDescription(): ?string;

    public function setDescription(?string $description);

    public function getCreatedAt(): \DateTime;

    public function setCreatedAt(\DateTime $createdAt);

    public function getUpdatedAt(): ?\DateTime;

    public function setUpdatedAt(\DateTime $updatedAt);
}
