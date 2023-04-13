<?php

namespace ContainerHxLeubD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getVersioningServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Service\VersioningService' shared autowired service.
     *
     * @return \App\Service\VersioningService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Service/VersioningService.php';

        return $container->privates['App\\Service\\VersioningService'] = new \App\Service\VersioningService(($container->services['request_stack'] ??= new \Symfony\Component\HttpFoundation\RequestStack()), ($container->privates['parameter_bag'] ??= new \Symfony\Component\DependencyInjection\ParameterBag\ContainerBag($container)));
    }
}
