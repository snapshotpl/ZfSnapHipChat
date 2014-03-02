<?php

namespace ZfSnapHipChat\Log;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceManager;

/**
 * Logger with hipchat writer factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * @param ServiceManager $sm
     * @return \Zend\Log\Logger
     */
    public function createService(ServiceManager $sm)
    {
        /* @var $writer \ZfSnapHipChat\Log\Writer\HipChat */
        $writer = $sm->get('hipchat_log_writer');
        /* @var $logger \Zend\Log\Logger */
        $logger = $sm->get('Zend\Log\Logger');
        $logger->addWriter($writer);

        return $logger;
    }

}
