<?php
use HipChat\HipChat;

return [
    'zf_snap_hip_chat' => [
        'api' => [
            'auth_token' => null,
            'api_target' => HipChat::DEFAULT_TARGET,
            'api_version' => HipChat::VERSION_1,
        ],
        'logger' => [
            'room_id' => null,
            'from' => 'ZfSnapHipChat',
            'notify' => false,
            'format' => HipChat::FORMAT_HTML,
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'hipchat' => HipChat\HipChat::class,
            'hipchat_logger' => 'ZfSnapHipChat\Log\Logger',
            'hipchat_log_writer' => ZfSnapHipChat\Log\Writer\HipChat::class,
        ],
        'invokables' => [
            Zend\Log\Logger::class => Zend\Log\Logger::class,
        ],
        'factories' => [
            HipChat\HipChat::class => ZfSnapHipChat\HipChatFactory::class,
            'ZfSnapHipChat\Log\Logger' => ZfSnapHipChat\Log\LoggerFactory::class,
            ZfSnapHipChat\Log\Writer\HipChat::class => ZfSnapHipChat\Log\Writer\HipChatFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            'ZfSnapHipChat\Controller\Console' => ZfSnapHipChat\Controller\ConsoleControllerFactory::class,
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'hipchat-message-send' => [
                    'options' => [
                        'route' => ZfSnapHipChat\Module::CONSOLE_MESSAGE_SEND,
                        'defaults' => [
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'message',
                        ],
                    ],
                ],
                'hipchat-room-list' => [
                    'options' => [
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_LIST,
                        'defaults' => [
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-list',
                        ],
                    ],
                ],
                'hipchat-room-history' => [
                    'options' => [
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_HISTORY,
                        'defaults' => [
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-history',
                        ],
                    ],
                ],
                'hipchat-room-set-topic' => [
                    'options' => [
                        'route' => ZfSnapHipChat\Module::CONSOLE_ROOM_SET_TOPIC,
                        'defaults' => [
                            'controller' => 'ZfSnapHipChat\Controller\Console',
                            'action' => 'room-set-topic',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
