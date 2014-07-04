<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // -----------------------------------------------------------------
            // Symfony 2 Standard Edition
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            // -----------------------------------------------------------------
            // JMSSecurityExtraBundle
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),

            // -----------------------------------------------------------------
            // FOSUserBundle
            new Cekurte\UserBundle\CekurteUserBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            // new EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle(),

            // -----------------------------------------------------------------
            // Paginação
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            // -----------------------------------------------------------------
            // CekurteGeneratorBundle - Customização do SensioGeneratorBundle
            new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
            new Cekurte\GeneratorBundle\CekurteGeneratorBundle(),

            // -----------------------------------------------------------------
            // Tools
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),
            new Cekurte\UploaderBundle\CekurteUploaderBundle(),
            new Cekurte\PageBundle\CekurtePageBundle(),

            // -----------------------------------------------------------------
            // Bundles do Projeto "/src"
            new Cekurte\Custom\UserBundle\CekurteCustomUserBundle(),
            new Cekurte\Custom\GeneratorBundle\CekurteCustomGeneratorBundle(),
            new Cekurte\Admin\DashboardBundle\CekurteAdminDashboardBundle(),
            new Cekurte\SiteBundle\CekurteSiteBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Hautelook\AliceBundle\HautelookAliceBundle();
            $bundles[] = new Cekurte\FixturesBundle\CekurteFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
