<?php

namespace ZfSnapHipChat\Log\Writer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Exception;

/**
 * HipChat log writer factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class HipChatFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return HipChat
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hipchat = $serviceLocator->get('hipchat');
        $config = $serviceLocator->get('config');
        $loggerConfig = $config['zf_snap_hip_chat']['logger'];
        $room_id = $loggerConfig['room_id'];
        $from = $loggerConfig['from'];
        $notify = $loggerConfig['notify'];
        $format = $loggerConfig['format'];

        if (empty($room_id)) {
            throw new Exception('Missing room id');
        }
        $logger = new HipChat($hipchat, $room_id, $from, $notify, $format);

        return $logger;
    }

}
