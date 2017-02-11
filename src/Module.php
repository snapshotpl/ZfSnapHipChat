<?php

namespace ZfSnapHipChat;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface as Config;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface as Console;

/**
 * HipChat module
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Module implements Config, Console
{
    const CONSOLE_MESSAGE_SEND = 'hipchat message send <message> [--room=] [--from=] [--notify] [--color=(yellow|red|gray|green|purple|random)] [--format=(html|text)]';
    const CONSOLE_ROOM_LIST = 'hipchat room list';
    const CONSOLE_ROOM_HISTORY = 'hipchat room history <room> [--date=]';
    const CONSOLE_ROOM_SET_TOPIC = 'hipchat room set topic <room> <topic> [--from=]';

    public function getConfig()
    {
        return include __DIR__ . '/config/hipchat.config.php';
    }

    /**
     * @param AdapterInterface $console
     * @return array
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'HipChat API',
            self::CONSOLE_MESSAGE_SEND => 'Sends message',
            self::CONSOLE_ROOM_LIST => 'Lists rooms',
            self::CONSOLE_ROOM_HISTORY => 'Room\'s history',
            self::CONSOLE_ROOM_SET_TOPIC => 'Sets room topic',
        );
    }
}