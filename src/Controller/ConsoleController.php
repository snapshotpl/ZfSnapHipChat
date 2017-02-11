<?php

namespace ZfSnapHipChat\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\ColorInterface as Color;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;
use HipChat\HipChat;
use Exception;

/**
 * ConsoleController
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ConsoleController extends AbstractActionController
{
    /**
     * @var Console
     */
    protected $console;

    /**
     * @var HipChat
     */
    protected $hipchat;

    /**
     * @var string|string[]
     */
    protected $room;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var bool
     */
    protected $notify;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $format;

    /**
     *
     * @param Console $console
     * @param HipChat $hipChat
     */
    public function __construct(Console $console, HipChat $hipChat)
    {
        $this->console = $console;
        $this->hipchat = $hipChat;
    }

    /**
     * @param string|string[] $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @param bool $notify
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(RequestInterface $request, ResponseInterface $response = null)
    {
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can use this controller only from a console!');
        }
        return parent::dispatch($request, $response);
    }

    public function messageAction()
    {
        $message = $this->params('message');
        $room = $this->params('room', $this->room);
        $from = $this->params('from', $this->from);
        $notify = $this->params('notify');
        $color = $this->params('color', $this->color);
        $format = $this->params('format', $this->format);

        try {
            if (is_array($room)) {
                foreach ($room as $oneRoom) {
                    if (!$this->hipchat->message_room($oneRoom, $from, $message, $notify, $color, $format)) {
                        throw new Exception(sprintf('Message didn\'t send to room "%s"', $oneRoom));
                    }
                }
                $roomName = join(', ', $room);
            } else {
                if (!$this->hipchat->message_room($room, $from, $message, $notify, $color, $format)) {
                    throw new Exception(sprintf('Message didn\'t send to room "%s"', $room));
                }
                $roomName = $room;
            }
            $this->console->writeLine(sprintf('Message sent to room "%s"', $roomName), Color::GREEN);
        } catch (Exception $e) {
            $this->console->writeLine(sprintf('Message did not sent: "%s"', $e->getMessage()), Color::RED);
        }
    }

    public function roomListAction()
    {
        try {
            $rooms = $this->hipchat->get_rooms();

            foreach ($rooms as $room) {
                $this->console->writeLine($room->roomIds .': '. $room->name);
            }
        } catch (Exception $e) {
            $this->console->writeLine(sprintf('Rooms list did not fetch: "%s"', $e->getMessage()), Color::RED);
        }
    }

    public function roomHistoryAction()
    {
        $room = $this->params('room');
        $date = $this->params('date', 'recent');

        try {
            $messages = $this->hipchat->get_rooms_history($room, $date);

            foreach ($messages as $message) {
                $this->console->writeLine($message->from->name .', '. $message->date, Color::BLACK, Color::WHITE);
                $this->console->writeLine($message->message);
            }
        } catch (Exception $e) {
            $this->console->writeLine(sprintf('Room\'s history did not fetch: "%s"', $e->getMessage()), Color::RED);
        }
    }

    public function roomSetTopicAction()
    {
        $room = $this->params('room');
        $topic = $this->params('topic');
        $from = $this->params('from', $this->from);

        try {
            $this->hipchat->set_room_topic($room, $topic, $from);
            $this->console->writeLine(sprintf('Room "%s" has topic "%s"', $room, $topic), Color::GREEN);
        } catch (Exception $e) {
            $this->console->writeLine($e->getMessage(), Color::RED);
        }
    }
}
