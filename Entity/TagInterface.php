<?php

namespace Enguys\CoreBundle\Entity;

interface TagInterface
{
    public function getId(): ?string;

    public function getName(): ?string;
}
