<?php

namespace ZfSnapHipChat\Log\Writer;

use HipChat\HipChat as HipChatApi;
use InvalidArgumentException;
use Zend\Log\Logger;
use Zend\Log\Writer\AbstractWriter;

/**
 * HipChat log writer
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class HipChat extends AbstractWriter
{

    /**
     * @var HipChatApi
     */
    protected $hipchat;

    /**
     * @var int|int[]
     */
    protected $roomIds;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var bool
     */
    protected $notify;

    /**
     * @var array
     */
    protected $map = [
        Logger::EMERG => HipChatApi::COLOR_RED,
        Logger::ALERT => HipChatApi::COLOR_RED,
        Logger::CRIT => HipChatApi::COLOR_RED,
        Logger::ERR => HipChatApi::COLOR_RED,
        Logger::WARN => HipChatApi::COLOR_YELLOW,
        Logger::NOTICE => HipChatApi::COLOR_YELLOW,
        Logger::INFO => HipChatApi::COLOR_GREEN,
        Logger::DEBUG => HipChatApi::COLOR_GRAY,
    ];

    /**
     * @param HipChatApi $hipchat
     * @param int|int[] $roomIds
     * @param string $from
     * @param bool $notify
     * @param string $format
     */
    public function __construct(HipChatApi $hipchat, $roomIds, $from, $notify = false, $format = HipChatApi::FORMAT_HTML)
    {
        $this->hipchat = $hipchat;
        if (empty($roomIds)) {
            throw new InvalidArgumentException('Room id cannot be empty');
        }
        if (!is_array($roomIds)) {
            $roomIds = [$roomIds];
        }
        $this->roomIds = $roomIds;
        $this->from = $from;
        $this->notify = (bool) $notify;
        $this->format = $format;
    }

    /**
     * @param array $event
     */
    protected function doWrite(array $event)
    {
        $message = $event['message'];
        $color = $this->createColorFromPriority($event['priority']);

        foreach ($this->roomIds as $roomId) {
            $this->hipchat->message_room($roomId, $this->from, $message, $this->notify, $color);
        }
    }

    /**
     * @param int $priority
     * @return string
     */
    protected function createColorFromPriority($priority)
    {
        if (isset($this->map[$priority])) {
            return $this->map[$priority];
        }
        return HipChatApi::COLOR_GRAY;
    }
}
