<?php

namespace ContainerKZMbxY0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Y58uPq8Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Y58uPq8' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Y58uPq8'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'brand' => ['privates', '.errored..service_locator.Y58uPq8.App\\Entity\\Brand', NULL, 'Cannot autowire service ".service_locator.Y58uPq8": it needs an instance of "App\\Entity\\Brand" but this type has been excluded in "config/services.yaml".'],
            'serializer' => ['privates', 'serializer', 'getSerializerService', true],
        ], [
            'brand' => 'App\\Entity\\Brand',
            'serializer' => '?',
        ]);
    }
}
