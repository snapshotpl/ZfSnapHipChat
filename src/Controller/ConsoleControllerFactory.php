<?php

namespace ZfSnapHipChat\Controller;

use Interop\Container\ContainerInterface;

/**
 * Factory for console controller
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class ConsoleControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator();
        $console = $container->get('Console');
        $hipchat = $container->get('HipChat');
        $config = $container->get('Config');
        $hipchatConfig = $config['zf_snap_hip_chat']['logger'];

        $controller = new ConsoleController($console, $hipchat);
        $controller->setFormat($hipchatConfig['format']);
        $controller->setFrom($hipchatConfig['from']);
        $controller->setNotify($hipchatConfig['notify']);
        $controller->setRoom($hipchatConfig['room_id']);

        return $controller;
    }
}