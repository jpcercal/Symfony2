<?php

namespace Test\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class DefaultController
 *
 * @Rest\Prefix("/test")
 * @Rest\NamePrefix("testbundle_default")
 *
 * @package Test\TestBundle\Controller
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class DefaultController extends Controller
{
    /**
     * @Rest\Get(path="/{id}", name="test_test")
     * @Rest\View()
     *
     * @param int $id
     * @return array
     */
    public function indexAction($id)
    {
        return array('name' => $id);
    }
}
