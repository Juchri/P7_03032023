<?php

namespace Container6LZ6dTG;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_TRDWSAService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.tRDWS_A' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.tRDWS_A'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'mobileRepository' => ['privates', 'App\\Repository\\MobileRepository', 'getMobileRepositoryService', true],
            'serializer' => ['privates', 'serializer', 'getSerializerService', true],
        ], [
            'mobileRepository' => 'App\\Repository\\MobileRepository',
            'serializer' => '?',
        ]);
    }
}
