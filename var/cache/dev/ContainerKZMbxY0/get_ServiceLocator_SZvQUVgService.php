<?php

namespace ContainerKZMbxY0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_SZvQUVgService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.SZvQUVg' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.SZvQUVg'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'cachePool' => ['privates', 'cache.app.taggable', 'getCache_App_TaggableService', true],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
            'mobile' => ['privates', '.errored..service_locator.SZvQUVg.App\\Entity\\Mobile', NULL, 'Cannot autowire service ".service_locator.SZvQUVg": it needs an instance of "App\\Entity\\Mobile" but this type has been excluded in "config/services.yaml".'],
        ], [
            'cachePool' => '?',
            'em' => '?',
            'mobile' => 'App\\Entity\\Mobile',
        ]);
    }
}
