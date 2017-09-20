<?php

namespace Enguys\CoreBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagsDataTransformer implements DataTransformerInterface
{
    private $manager;

    private $entityName;

    public function __construct(EntityManagerInterface $manager, string $entityName)
    {
        $this->manager = $manager;
        $this->entityName = $entityName;
    }

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        $tags = $value->getValues();
        if (count($tags)) {
            $ids = [];
            /** @var \Enguys\CoreBundle\Entity\TagInterface $tag */
            foreach ($tags as $tag) {
                $ids[] = $tag->getId();
            }

            return implode(',', $ids);
        }
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        $tags = new ArrayCollection();
        if (empty($value)) {
            return $tags;
        }
        $ids = explode(',', $value);
        $exists = [];
        foreach ($ids as $id) {
            /** @var \Enguys\CoreBundle\Entity\TagInterface $tag */
            $tag = $this->manager->find($this->entityName, trim($id));
            $entityName = $this->entityName;
            if (!$tag instanceof $entityName) {
                $tag = new $entityName($id);
            }
            if (!in_array($tag->getId(), $exists)) {
                $tags->add($tag);
                $exists[] = $tag->getId();
            }
        }

        return $tags;
    }
}
