<?php

namespace ContainerD7RWJQF;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_Security_Firewall_Authenticator_LoginService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.security.firewall.authenticator.login' shared service.
     *
     * @return \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticatorManagerListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Firewall/FirewallListenerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Firewall/AbstractListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/Debug/TraceableAuthenticatorManagerListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Firewall/AuthenticatorManagerListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/AuthenticatorManagerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/UserAuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/AuthenticatorManager.php';

        $a = ($container->privates['security.authenticator.json_login.login'] ?? $container->load('getSecurity_Authenticator_JsonLogin_LoginService'));

        if (isset($container->privates['debug.security.firewall.authenticator.login'])) {
            return $container->privates['debug.security.firewall.authenticator.login'];
        }

        return $container->privates['debug.security.firewall.authenticator.login'] = new \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticatorManagerListener(new \Symfony\Component\Security\Http\Firewall\AuthenticatorManagerListener(new \Symfony\Component\Security\Http\Authentication\AuthenticatorManager([0 => $a], ($container->privates['security.token_storage'] ?? $container->getSecurity_TokenStorageService()), ($container->privates['security.event_dispatcher.login'] ?? $container->load('getSecurity_EventDispatcher_LoginService')), 'login', ($container->privates['logger'] ?? $container->getLoggerService()), true, true, [])));
    }
}
