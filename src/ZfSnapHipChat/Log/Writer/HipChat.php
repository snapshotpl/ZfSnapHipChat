<?php

namespace ZfSnapHipChat\Log\Writer;

use Zend\Log\Writer\AbstractWriter;
use HipChat\HipChat as HipChatApi;
use Zend\Log\Logger;

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
    protected $room_id;

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
    protected $map;

    /**
     * @param HipChatApi $hipchat
     * @param int|int[] $room_id
     * @param string $from
     * @param bool $notify
     * @param string $format
     */
    public function __construct(HipChatApi $hipchat, $room_id, $from, $notify = false, $format = HipChatApi::FORMAT_HTML)
    {
        $this->hipchat = $hipchat;
        $this->room_id = $room_id;
        $this->from = $from;
        $this->notify = (bool) $notify;
        $this->format = $format;
    }

    /**
     * @param array $event
     */
    protected function doWrite(array $event)
    {
        $api = $this->hipchat;
        $room_id = $this->room_id;
        $from = $this->from;
        $message = $event['message'];
        $notify = $this->notify;
        $color = $this->mapPriorityToColor($event['priority']);

        if (is_array($room_id)) {
            foreach ($room_id as $id) {
                $api->message_room($id, $from, $message, $notify, $color);
            }
        } else {
            $api->message_room($room_id, $from, $message, $notify, $color);
        }
    }

    /**
     * @param int $priority
     * @return string
     */
    protected function mapPriorityToColor($priority)
    {
        $map = $this->getMap();

        if (isset($map[$priority])) {
            return $map[$priority];
        } else {
            HipChatApi::COLOR_GRAY;
        }
    }

    /**
     * @return array
     */
    protected function getMap()
    {
        if ($this->map === null) {
            $this->map = array(
                Logger::EMERG => HipChatApi::COLOR_RED,
                Logger::ALERT => HipChatApi::COLOR_RED,
                Logger::CRIT => HipChatApi::COLOR_RED,
                Logger::ERR => HipChatApi::COLOR_RED,
                Logger::WARN => HipChatApi::COLOR_YELLOW,
                Logger::NOTICE => HipChatApi::COLOR_YELLOW,
                Logger::INFO => HipChatApi::COLOR_GREEN,
                Logger::DEBUG => HipChatApi::COLOR_GRAY,
            );
        }
        return $this->map;
    }

}
