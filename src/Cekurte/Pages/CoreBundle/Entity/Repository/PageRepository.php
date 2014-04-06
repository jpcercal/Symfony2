<?php

namespace Cekurte\Pages\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Cekurte\Pages\CoreBundle\Entity\Page;

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
    public function getQuery(Page $entity, $sort, $direction)
    {
        $queryBuilder = $this->createQueryBuilder('ck');

        $data = array(
            'slug'          => $entity->getSlug(),
            'title'         => $entity->getTitle(),
            'abstract'      => $entity->getAbstract(),
            'description'   => $entity->getDescription(),
            'active'        => $entity->getActive(),
        );

        if (!empty($data['slug'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('ck.slug', ':slug'))
                ->setParameter('slug', "%{$data['slug']}%")
            ;
        }

        if (!empty($data['title'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('ck.title', ':title'))
                ->setParameter('title', "%{$data['title']}%")
            ;
        }

        if (!empty($data['abstract'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('ck.abstract', ':abstract'))
                ->setParameter('abstract', $data['abstract'])
            ;
        }

        if (!empty($data['description'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('ck.description', ':description'))
                ->setParameter('description', $data['description'])
            ;
        }

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq('ck.active', ':active'))
            ->setParameter('active', !$data['active'])
        ;

        return $queryBuilder
            ->orderBy($sort, $direction)
            ->getQuery()
        ;
    }
}
