<?php

namespace Test\TestBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Test\TestBundle\Entity\Page;

/**
 * Class PageController
 *
 *
 * @package Test\TestBundle\Controller
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class PageController extends Controller
{
    /**
     * @Rest\Get("/pages")
     * @Rest\View()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $resources = $this->get('test_test.page.handler')->getResources($request);

        return array(
            'pagination' => $resources
        );
    }

    /**
     * @Rest\Get(path="/page/{id}")
     * @Rest\View()
     *
     * @param int $id
     * @return array
     */
    public function showAction($id)
    {
        return array(
            'resource' => $this->get('test_test.page.handler')->getResource($id)
        );
    }
}
