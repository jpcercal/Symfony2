<?php

namespace Cekurte\Admin\DashboardBundle\Controller;

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
     * @Route("/", name="cekurte_admin_dashboard")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
