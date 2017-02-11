<?php

namespace ZfSnapHipChat\Log;

use Interop\Container\ContainerInterface;
use Zend\Log\Logger;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceManager;
use ZfSnapHipChat\Log\Writer\HipChat;

/**
 * Logger with hipchat writer factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class LoggerFactory
{
    /**
     * @param ServiceManager $container
     * @return Logger
     */
    public function __invoke(ContainerInterface $container)
    {
        /* @var $writer HipChat */
        $writer = $container->get('hipchat_log_writer');
        /* @var $logger Logger */
        $logger = $container->get('Zend\Log\Logger');
        $logger->addWriter($writer);

        return $logger;
    }

}
