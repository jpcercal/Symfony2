<?php

namespace Test\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PageController
 *
 * @Rest\Prefix("/api")
 * @Rest\NamePrefix("testbundle_page")
 *
 *
 *
 * @package Test\TestBundle\Controller
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class PageController extends Controller
{
    /**
     * @Rest\Get(path="/pages", name="index")
     * @Rest\View()
     *
     * @return array
     */
    public function indexAction()
    {
        $entities = $this->get('test_test.page.handler')->all();

        return array('entities' => $entities);
    }

    /**
     * @Rest\Get(path="/page/{id}", name="show")
     * @Rest\View()
     *
     * @param int $id
     * @return array
     */
    public function showAction($id)
    {
        $entity = $this->get('test_test.page.handler')->get($id);

        return array('entity' => $entity);
    }
}
