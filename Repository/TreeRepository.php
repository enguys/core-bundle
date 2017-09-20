<?php

namespace Enguys\CoreBundle\Repository;

class TreeRepository extends EntityRepository
{
    public function getRootNodes()
    {
        return $this->findBy(['parent' => null], ['weight' => 'ASC']);
    }

    public function getFlatChildren()
    {
        $rootNodes = $this->getRootNodes();

        return $this->flatChildren($rootNodes);
    }

    public function childrenHierarchy(array $options)
    {
        $defaultOptions = [
            'rootOpen' => '<ul class="category-tree">',
            'rootClose' => '</ul>',
            'childOpen' => '<li class="category-tree__item">',
            'childClose' => '</li>',
            'nodeContent' => function ($category) {
                return (string)$category;
            },
        ];
        $options = array_merge($defaultOptions, $options);
        $nodes = $this->getRootNodes();
        if (count($nodes) === 0) {
            return '';
        }

        return $this->buildHtmlTree($nodes, $options);
    }

    private function flatChildren(array $nodes)
    {
        $data = [];
        /** @var \Enguys\CoreBundle\Entity\TreeInterface $node */
        foreach ($nodes as $node) {
            $data[] = $node;
            $children = $node->getChildren();
            if (!$children->isEmpty()) {
                $data = array_merge($data, $this->flatChildren($children->toArray()));
            }
        }

        return $data;
    }

    private function buildHtmlTree(array $nodes, array $options)
    {
        if (count($nodes) === 0) {
            return '';
        }
        /** @var \Enguys\CoreBundle\Entity\TreeInterface $node */
        $html = $options['rootOpen'];
        foreach ($nodes as $node) {
            $html .= $options['childOpen'];
            $html .= $options['nodeContent']($node);
            $children = $node->getChildren();
            if (!$children->isEmpty()) {
                $html .= $this->buildHtmlTree($children->toArray(), $options);
            }
            $html .= $options['childClose'];
        }
        $html .= $options['rootClose'];

        return $html;
    }
}
