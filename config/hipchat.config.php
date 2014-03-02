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
            'hipchat' => 'HipChat\HipChat',
            'hipchat_log_writer' => 'ZfSnapHipChat\Log\Writer\HipChat',
        ),
        'factories' => array(
            'HipChat\HipChat' => 'ZfSnapHipChat\Factory',
            'ZfSnapHipChat\Log\Writer\HipChat' => 'ZfSnapHipChat\Log\Writer\HipChatFactory',
        ),
    ),
);
