<?php

namespace ContainerKoJNvDt;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_U1eLwaYService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.U1eLwaY' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.U1eLwaY'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'brandRepository' => ['privates', 'App\\Repository\\BrandRepository', 'getBrandRepositoryService', true],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
            'serializer' => ['privates', 'serializer', 'getSerializerService', true],
            'urlGenerator' => ['services', 'router', 'getRouterService', false],
        ], [
            'brandRepository' => 'App\\Repository\\BrandRepository',
            'em' => '?',
            'serializer' => '?',
            'urlGenerator' => '?',
        ]);
    }
}
