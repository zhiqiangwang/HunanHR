<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            new HR\UserBundle\HRUserBundle(),
            new HR\BreadcrumbBundle\HRBreadcrumbBundle(),
            new HR\PositionBundle\HRPositionBundle(),
            new HR\EducationBundle\HREducationBundle(),
            new HR\SkillBundle\HRSkillBundle(),
            new HR\CareerBundle\HRCareerBundle(),
            new HR\LocationBundle\HRLocationBundle(),
            new HR\PageBundle\HRPageBundle(),
            new HR\MailerBundle\HRMailerBundle(),
            new HR\NotificationBundle\HRNotificationBundle(),
            new HR\OAuthBundle\HROAuthBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
