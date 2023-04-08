<?php

namespace Container6Ol5PwU;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_DfP61RHService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.dfP61RH' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.dfP61RH'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'brandRepository' => ['privates', 'App\\Repository\\BrandRepository', 'getBrandRepositoryService', true],
            'currentBrand' => ['privates', '.errored..service_locator.dfP61RH.App\\Entity\\Brand', NULL, 'Cannot autowire service ".service_locator.dfP61RH": it needs an instance of "App\\Entity\\Brand" but this type has been excluded in "config/services.yaml".'],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
            'serializer' => ['privates', 'serializer', 'getSerializerService', true],
        ], [
            'brandRepository' => 'App\\Repository\\BrandRepository',
            'currentBrand' => 'App\\Entity\\Brand',
            'em' => '?',
            'serializer' => '?',
        ]);
    }
}
