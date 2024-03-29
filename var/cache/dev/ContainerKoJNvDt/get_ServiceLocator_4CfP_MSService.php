<?php

namespace ContainerKoJNvDt;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_4CfP_MSService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.4CfP.mS' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.4CfP.mS'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'clientRepository' => ['privates', 'App\\Repository\\ClientRepository', 'getClientRepositoryService', true],
            'currentClient' => ['privates', '.errored..service_locator.4CfP.mS.App\\Entity\\Client', NULL, 'Cannot autowire service ".service_locator.4CfP.mS": it needs an instance of "App\\Entity\\Client" but this type has been excluded in "config/services.yaml".'],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
            'serializer' => ['services', 'jms_serializer', 'getJmsSerializerService', true],
        ], [
            'clientRepository' => 'App\\Repository\\ClientRepository',
            'currentClient' => 'App\\Entity\\Client',
            'em' => '?',
            'serializer' => '?',
        ]);
    }
}
