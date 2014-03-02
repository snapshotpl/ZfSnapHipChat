<?php

namespace ZfSnapHipChat;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HipChat\HipChat;
use Exception;

/**
 * HipChat Factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Factory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return HipChat
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        $hipChatConfig = $config['zf_snap_hip_chat']['api'];
        $auth_token = $hipChatConfig['auth_token'];
        $api_target = $hipChatConfig['api_target'];
        $api_version = $hipChatConfig['api_version'];

        if (null === $auth_token) {
            throw new Exception('Missing API Auth Token');
        }

        $hipchat = new HipChat($auth_token, $api_target, $api_version);

        return $hipchat;
    }
}
