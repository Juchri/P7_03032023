<?php

namespace Container9WwKTxh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_Describers_ConfigService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'nelmio_api_doc.describers.config' shared service.
     *
     * @return \Nelmio\ApiDocBundle\Describer\ExternalDocDescriber
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Describer/DescriberInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Describer/ExternalDocDescriber.php';

        return $container->privates['nelmio_api_doc.describers.config'] = new \Nelmio\ApiDocBundle\Describer\ExternalDocDescriber(['info' => ['title' => 'BileMo', 'description' => 'BileMo, l\'API qui permet d\'échanger des mobiles entre utilisateurs et clients !', 'version' => '2.0.0'], 'paths' => ['/api/login_check' => ['post' => ['tags' => [0 => 'Token'], 'operationId' => 'postCredentialsItem', 'summary' => 'Permet d\'obtenir le token JWT pour se logger.', 'requestBody' => ['description' => 'Crée un nouveau token JWT', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Credentials']]]], 'responses' => [200 => ['description' => 'Récupère le token JWT', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Token']]]]]]]], 'components' => ['schemas' => ['Token' => ['type' => 'object', 'properties' => ['token' => ['type' => 'string', 'readOnly' => true]]], 'Credentials' => ['type' => 'object', 'properties' => ['username' => ['type' => 'string', 'default' => 'admin@bookapi.com'], 'password' => ['type' => 'string', 'default' => 'password']]]], 'securitySchemes' => ['bearerAuth' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'Authorization']]], 'security' => [0 => ['bearerAuth' => []]]]);
    }
}
