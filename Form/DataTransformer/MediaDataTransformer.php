<?php

namespace Enguys\CoreBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Enguys\CoreBundle\Entity\Media;
use Symfony\Component\Form\DataTransformerInterface;

class MediaDataTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        $items = $value->getValues();
        if (count($items)) {
            $ids = [];
            /** @var \Enguys\CoreBundle\Entity\Media $item */
            foreach ($items as $item) {
                $ids[] = $item->getId();
            }

            return implode(',', $ids);
        }
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        $items = new ArrayCollection();
        if (empty($value)) {
            return $items;
        }
        $ids = explode(',', $value);
        $exists = [];
        foreach ($ids as $id) {
            /** @var \Enguys\CoreBundle\Entity\Media $item */
            $item = $this->manager->find(Media::class, trim($id));
            if ($item instanceof Media && !in_array($item->getId(), $exists)) {
                $items->add($item);
                $exists[] = $item->getId();
            }
        }

        return $items;
    }
}
