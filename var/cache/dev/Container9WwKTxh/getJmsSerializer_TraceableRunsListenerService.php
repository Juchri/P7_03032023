<?php

namespace Container9WwKTxh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getJmsSerializer_TraceableRunsListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'jms_serializer.traceable_runs_listener' shared service.
     *
     * @return \JMS\SerializerBundle\Debug\RunsListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer-bundle/Debug/RunsListener.php';

        return $container->privates['jms_serializer.traceable_runs_listener'] = new \JMS\SerializerBundle\Debug\RunsListener();
    }
}
