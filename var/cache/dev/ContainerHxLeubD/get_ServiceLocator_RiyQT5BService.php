<?php

namespace ContainerHxLeubD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_RiyQT5BService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.riyQT5B' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.riyQT5B'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'brand' => ['privates', '.errored..service_locator.riyQT5B.App\\Entity\\Brand', NULL, 'Cannot autowire service ".service_locator.riyQT5B": it needs an instance of "App\\Entity\\Brand" but this type has been excluded in "config/services.yaml".'],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
        ], [
            'brand' => 'App\\Entity\\Brand',
            'em' => '?',
        ]);
    }
}
