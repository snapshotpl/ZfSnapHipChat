<?php

use HipChat\HipChat;

return array(
    'zf_snap_hip_chat' => array(
        'api' => array(
            'auth_token' => null,
            'api_target' => HipChat::DEFAULT_TARGET,
            'api_version' => HipChat::VERSION_1,
        ),
        'logger' => array(
            'room_id' => null,
            'from' => 'ZfSnapHipChat',
            'notify' => false,
            'format' => HipChat::FORMAT_HTML,
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'hipchat'            => 'HipChat\HipChat',
            'hipchat_logger'     => 'ZfSnapHipChat\Log\Logger',
            'hipchat_log_writer' => 'ZfSnapHipChat\Log\Writer\HipChat',
        ),
        'invokables' => array(
            'Zend\Log\Logger' => 'Zend\Log\Logger',
        ),
        'factories' => array(
            'HipChat\HipChat'                  => 'ZfSnapHipChat\HipChatFactory',
            'ZfSnapHipChat\Log\Logger'         => 'ZfSnapHipChat\Log\LoggerFactory',
            'ZfSnapHipChat\Log\Writer\HipChat' => 'ZfSnapHipChat\Log\Writer\HipChatFactory',
        ),
    ),
);
