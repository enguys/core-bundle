<?php

namespace Enguys\CoreBundle\Repository;

class TagRepository extends EntityRepository
{
    public function search($query = '')
    {
        $queryBuilder = $this->createQueryBuilder('t');
        if ($query === '') {
            return [];
        }
        $query = strtolower($query);
        $queryBuilder->where(
            $queryBuilder
                ->expr()
                ->like(
                    't.name',
                    $queryBuilder->expr()->literal('%'.$query.'%')
                )
        );

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
