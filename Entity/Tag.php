<?php

namespace Enguys\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Enguys\CoreBundle\Util\Slugger;

abstract class Tag implements TagInterface
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    public function __construct($name)
    {
        $this->id = Slugger::slugify($name);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
