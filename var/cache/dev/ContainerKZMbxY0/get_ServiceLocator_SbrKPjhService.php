<?php

namespace ContainerKZMbxY0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_SbrKPjhService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.sbrKPjh' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.sbrKPjh'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'cache' => ['privates', 'cache.app.taggable', 'getCache_App_TaggableService', true],
            'currentUser' => ['privates', '.errored..service_locator.sbrKPjh.App\\Entity\\User', NULL, 'Cannot autowire service ".service_locator.sbrKPjh": it needs an instance of "App\\Entity\\User" but this type has been excluded in "config/services.yaml".'],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
            'hash' => ['privates', 'security.user_password_hasher', 'getSecurity_UserPasswordHasherService', true],
            'validator' => ['privates', 'validator', 'getValidatorService', true],
        ], [
            'cache' => '?',
            'currentUser' => 'App\\Entity\\User',
            'em' => '?',
            'hash' => '?',
            'validator' => '?',
        ]);
    }
}
