<?php

use HipChat\HipChat;

return array(
    'zf_snap_hip_chat' => array(
        'auth_token' => '',
        'api_target' => HipChat::DEFAULT_TARGET,
        'api_version' => HipChat::VERSION_1,
    ),
    'service_manager' => array(
        'aliases' => array(
            'hipchat' => 'HipChat\HipChat',
        ),
        'factories' => array(
            'HipChat\HipChat' => 'ZfSnapHipChat\Factory',
        ),
    ),
);
