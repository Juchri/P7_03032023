<?php

namespace ContainerOG0TM0S;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Q_Wxh1_Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.q.Wxh1.' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.q.Wxh1.'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'mobile' => ['privates', '.errored..service_locator.q.Wxh1..App\\Entity\\Mobile', NULL, 'Cannot autowire service ".service_locator.q.Wxh1.": it needs an instance of "App\\Entity\\Mobile" but this type has been excluded in "config/services.yaml".'],
            'serializer' => ['services', 'jms_serializer', 'getJmsSerializerService', true],
            'versioningService' => ['privates', '.errored..service_locator.q.Wxh1..App\\Service\\VersioningService', NULL, 'Cannot autowire service ".service_locator.q.Wxh1.": it references class "App\\Service\\VersioningService" but no such service exists.'],
        ], [
            'mobile' => 'App\\Entity\\Mobile',
            'serializer' => '?',
            'versioningService' => 'App\\Service\\VersioningService',
        ]);
    }
}
