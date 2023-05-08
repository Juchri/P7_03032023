<?php

namespace ContainerKZMbxY0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_ErOnR4hService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ErOnR4h' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ErOnR4h'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'serializer' => ['services', 'jms_serializer', 'getJmsSerializerService', true],
            'user' => ['privates', '.errored..service_locator.ErOnR4h.App\\Entity\\User', NULL, 'Cannot autowire service ".service_locator.ErOnR4h": it needs an instance of "App\\Entity\\User" but this type has been excluded in "config/services.yaml".'],
        ], [
            'serializer' => '?',
            'user' => 'App\\Entity\\User',
        ]);
    }
}
