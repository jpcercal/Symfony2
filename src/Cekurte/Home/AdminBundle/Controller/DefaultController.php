<?php

namespace Cekurte\Home\AdminBundle\Controller;

use Cekurte\GeneratorBundle\Controller\CekurteController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default Controller
 *
 * @author  João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class DefaultController extends CekurteController
{
    /**
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
