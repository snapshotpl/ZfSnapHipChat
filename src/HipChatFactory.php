<?php

namespace ZfSnapHipChat;

use HipChat\HipChat;
use Interop\Container\ContainerInterface;

/**
 * HipChat Factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class HipChatFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        $hipChatConfig = $config['zf_snap_hip_chat']['api'];
        $authToken = $hipChatConfig['auth_token'];
        $apiTarget = $hipChatConfig['api_target'];
        $apiVersion = $hipChatConfig['api_version'];

        return new HipChat($authToken, $apiTarget, $apiVersion);
    }
}
