<?php

namespace Test\TestBundle\Service;

use Cekurte\ComponentBundle\Util\DoctrineContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class BaseHandler
 *
 * @package Test\TestBundle\Service
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
interface HandlerInterface
{
    /**
     * Get a resource given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function get($id);

    /**
     * Get a list of resources.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 10, $offset = 0);
} 