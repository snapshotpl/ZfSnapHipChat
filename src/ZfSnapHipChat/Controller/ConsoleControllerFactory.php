<?php

namespace ZfSnapHipChat\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for console controller
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ConsoleControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $sm = $sm->getServiceLocator();
        $console = $sm->get('Console');
        $hipchat = $sm->get('HipChat');
        $config = $sm->get('Config');
        $hipchatConfig = $config['zf_snap_hip_chat']['logger'];

        $controller = new ConsoleController($console, $hipchat);
        $controller->setFormat($hipchatConfig['format']);
        $controller->setFrom($hipchatConfig['from']);
        $controller->setNotify($hipchatConfig['notify']);
        $controller->setRoom($hipchatConfig['room_id']);

        return $controller;
    }
}