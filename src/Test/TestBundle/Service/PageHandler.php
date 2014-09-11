<?php

namespace Test\TestBundle\Service;

use Cekurte\ComponentBundle\Util\DoctrineContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class PageHandler
 *
 * @package Test\TestBundle\Service
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class PageHandler extends DoctrineContainerAware implements HandlerInterface
{
    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $entity = $this->getRepository('TestTestBundle:Page')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function all($limit = 10, $offset = 0)
    {
        return $this->getRepository('TestTestBundle:Page')->findAll();
    }
}