<?php

namespace ZfSnapHipChat\Log\Writer;

use Interop\Container\ContainerInterface;

/**
 * HipChat log writer factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class HipChatFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $hipchat = $container->get('hipchat');
        $config = $container->get('config');
        $loggerConfig = $config['zf_snap_hip_chat']['logger'];

        $roomId = $loggerConfig['room_id'];
        $from = $loggerConfig['from'];
        $notify = $loggerConfig['notify'];
        $format = $loggerConfig['format'];

        return new HipChat($hipchat, $roomId, $from, $notify, $format);
    }

}
