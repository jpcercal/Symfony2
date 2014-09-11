<?php

namespace Test\TestBundle\Service;

use Cekurte\ComponentBundle\Util\DoctrineContainerAware;
use Cekurte\GeneratorBundle\Service\Manager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class PageHandler
 *
 * @package Test\TestBundle\Service
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class PageHandler extends Manager
{
    /**
     * @inheritdoc
     */
    protected function getResourceClass()
    {
        return 'TestTestBundle:Page';
    }
}