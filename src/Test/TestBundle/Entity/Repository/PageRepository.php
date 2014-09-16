<?php

namespace Test\TestBundle\Entity\Repository;

use Cekurte\GeneratorBundle\Doctrine\EntityRepository;
use Test\TestBundle\Entity\Page;

/**
 * Page Repository.
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 0.1
 */
class PageRepository extends EntityRepository
{
    /**
     * Search for records based on an entity
     *
     * @param Page $entity
     * @param string $sort
     * @param string $direction
     * @return \Doctrine\ORM\Query
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function getQuery($entity, $sort, $direction)
    {
        $queryBuilder = $this->createQueryBuilder('ck');

        $data = array(
            'title' => $entity->getTitle(),
        );

        if (!empty($data['title'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('ck.title', ':title'))
                ->setParameter('title', "%{$data['title']}%")
            ;
        }

        return $queryBuilder
            ->orderBy($sort, $direction)
            ->getQuery()
        ;
    }
}
