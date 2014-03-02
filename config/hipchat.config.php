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
    'controllers' => array(
        'factories' => array(
            'ZfSnapHipChat\Controller\Console' => 'ZfSnapHipChat\Controller\ConsoleControllerFactory',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'hipchat-message-send' => array(
                    'options' => array(
                        'route' => ZfSnapHipChat\Module::CONSOLE_MESSAGE_SEND,
                        'defaults' => array(
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'message',
                        ),
                    ),
                ),
                'hipchat-room-list' => array(
                    'options' => array(
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_LIST,
                        'defaults' => array(
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-list',
                        ),
                    ),
                ),
                'hipchat-room-history' => array(
                    'options' => array(
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_HISTORY,
                        'defaults' => array(
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-history',
                        ),
                    ),
                ),
                'hipchat-room-set-topic' => array(
                    'options' => array(
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_SET_TOPIC,
                        'defaults' => array(
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-set-topic',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
