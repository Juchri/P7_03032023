<?php

namespace Container6Ol5PwU;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_NfaZhBuService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.nfaZhBu' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.nfaZhBu'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'mobile' => ['privates', '.errored..service_locator.nfaZhBu.App\\Entity\\Mobile', NULL, 'Cannot autowire service ".service_locator.nfaZhBu": it needs an instance of "App\\Entity\\Mobile" but this type has been excluded in "config/services.yaml".'],
            'serializer' => ['privates', 'serializer', 'getSerializerService', true],
        ], [
            'mobile' => 'App\\Entity\\Mobile',
            'serializer' => '?',
        ]);
    }
}
