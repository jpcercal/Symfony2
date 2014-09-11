<?php

namespace Test\TestBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
     * Get a filtered Query
     *
     * @param array $queryString
     *
     * @return \Doctrine\ORM\Query
     */
    public function getFilteredQuery(array $queryString)
    {
        $queryBuilder = $this->createQueryBuilder('ck');

        // ?count=ck.id:asc
        if (!is_null($queryString['count'])) {
            $queryBuilder->select('COUNT(ck.id) numberOfResources');
        } else {
            // ?fields=ck.id,ck.title
            if (!is_null($queryString['fields'])) {
                $queryBuilder->select($queryString['fields']);
            }
        }

        // ?sort=ck.id:asc,ck.title:desc
        if (!is_null($queryString['sort'])) {
            foreach ($queryString['sort'] as $item) {
                $data = explode(':', $item);
                $queryBuilder->orderBy($data[0], $data[1]);
            }
        }

        // ?filters=ck.id:eq:1,ck.title:like:test
        if (!is_null($queryString['filters'])) {
            foreach ($queryString['filters'] as $item) {
                $data = explode(':', $item);

                $field      = $data[0];
                $fieldParam = str_replace('.', '', $field);
                $condition  = strtolower($data[1]);
                $value      = $condition === 'like' ? '%' . $data[2] . '%' : $data[2];

                $queryBuilder
                    ->andWhere($queryBuilder->expr()->{$condition}($field, ':' . $fieldParam))
                    ->setParameter($fieldParam, $value)
                ;
            }
        }

        // ?joins=ck.categories:cat:inner,ck.categories:cat:left:eq:test
        if (!is_null($queryString['joins'])) {
            foreach ($queryString['joins'] as $item) {
                $data = explode(':', $item);

                $suffix     = 'Join';
                $field      = $data[0];
                $alias      = $data[1];
                $joinType   = strtolower($data[2]) . $suffix;

                if (!isset($data[3]) and !isset($data[4])) {
                    $queryBuilder->{$joinType}($field, $alias);
                } else {

                    $fieldParam = str_replace('.', '', $field) . $suffix;
                    $condition  = strtolower($data[3]);
                    $value      = $condition === 'like' ? '%' . $data[4] . '%' : $data[4];

                    $queryBuilder
                        ->{$joinType}($field, $alias, Join::WITH, $queryBuilder->expr()->{$condition}($field, ':' . $fieldParam))
                        ->setParameter($fieldParam, $value)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

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
