<?php

namespace ContainerMbYnDSy;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getHateoas_Configuration_MetadataDriverService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'hateoas.configuration.metadata_driver' shared service.
     *
     * @return \Metadata\Driver\DriverChain
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Driver/DriverInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Driver/AdvancedDriverInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Driver/DriverChain.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Driver/AbstractFileDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/willdurand/hateoas/src/Configuration/Metadata/Driver/CheckExpressionTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/willdurand/hateoas/src/Configuration/Metadata/Driver/YamlDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/willdurand/hateoas/src/Configuration/Metadata/Driver/XmlDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/willdurand/hateoas/src/Configuration/Metadata/Driver/ExtensionDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/willdurand/hateoas/src/Configuration/Metadata/Driver/AnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Type/ParserInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Type/Parser.php';

        $a = ($container->privates['jms_serializer.metadata.traceable_file_locator'] ?? $container->load('getJmsSerializer_Metadata_TraceableFileLocatorService'));
        $b = ($container->privates['jms_serializer.expression_evaluator'] ?? $container->load('getJmsSerializer_ExpressionEvaluatorService'));
        $c = ($container->services['hateoas.configuration.provider'] ?? $container->load('getHateoas_Configuration_ProviderService'));
        $d = ($container->privates['jms_serializer.type_parser'] ??= new \JMS\Serializer\Type\Parser());

        return $container->services['hateoas.configuration.metadata_driver'] = new \Metadata\Driver\DriverChain([0 => new \Hateoas\Configuration\Metadata\Driver\YamlDriver($a, $b, $c, $d), 1 => new \Hateoas\Configuration\Metadata\Driver\XmlDriver($a, $b, $c, $d), 2 => new \Hateoas\Configuration\Metadata\Driver\ExtensionDriver(new \Hateoas\Configuration\Metadata\Driver\AnnotationDriver(($container->privates['annotations.cached_reader'] ?? $container->getAnnotations_CachedReaderService()), $b, $c, $d))]);
    }
}
