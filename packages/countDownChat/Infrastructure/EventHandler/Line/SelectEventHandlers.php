<?php


namespace CountDownChat\Infrastructure\EventHandler\Line;


use CountDownChat\Infrastructure\EventHandler\Line\MessageHandler\TextMessageHandler;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\UnfollowEvent;
use Log;
use Shared\EventHandler\Line\LineEventHandler;

/**
 * イベントインスタンスによって、処理を切り分ける
 * @link https://github.com/line/line-bot-sdk-php/blob/master/examples/KitchenSink/src/LINEBot/KitchenSink/Route.php#L85
 *
 * Class SelectEventHandlers
 * @package CountDownChat\Infrastructure\EventHandler\Line
 */
class SelectEventHandlers
{
    private FollowEventHandler $followEventHandler;
    private UnfollowEventHandler $unFollowEventHandler;
    private TextMessageHandler $textMessageHandler;

    /**
     * SelectEventHandlers constructor.
     * @param  FollowEventHandler  $followEventHandler
     * @param  UnfollowEventHandler  $unFollowEventHandler
     * @param  TextMessageHandler  $textMessageHandler
     */
    public function __construct(
        FollowEventHandler $followEventHandler,
        UnfollowEventHandler $unFollowEventHandler,
        TextMessageHandler $textMessageHandler
    ) {
        $this->followEventHandler = $followEventHandler;
        $this->unFollowEventHandler = $unFollowEventHandler;
        $this->textMessageHandler = $textMessageHandler;
    }


    /**
     * @param $event
     * @return LineEventHandler|null
     */
    public function select($event)
    {
        if ($event instanceof MessageEvent) {
            return $this->textMessageHandler->setEvent($event);
        } elseif ($event instanceof FollowEvent) {
            return $this->followEventHandler->setEvent($event);
        } elseif ($event instanceof UnfollowEvent) {
            return $this->unFollowEventHandler->setEvent($event);
        }

        Log::info(sprintf(
            'Unexpected event type has come, something wrong [class name: %s]',
            get_class($event)
        ));

        return null;


        /*
                if ($event instanceof MessageEvent) {
                    if ($event instanceof TextMessage) {
                        // $handler = new TextMessageHandler($bot, $logger, $req, $event);
                    } elseif ($event instanceof StickerMessage) {
                        // $handler = new StickerMessageHandler($event);
                    } elseif ($event instanceof LocationMessage) {
                        // $handler = new LocationMessageHandler($event);
                    } elseif ($event instanceof ImageMessage) {
                        // $handler = new ImageMessageHandler($bot, $logger, $req, $event);
                    } elseif ($event instanceof AudioMessage) {
                        // $handler = new AudioMessageHandler($bot, $logger, $req, $event);
                    } elseif ($event instanceof VideoMessage) {
                        // $handler = new VideoMessageHandler($bot, $logger, $req, $event);
                    } elseif ($event instanceof UnknownMessage) {
                        Log::info(sprintf(
                            'Unknown message type has come [message type: %s]',
                            $event->getMessageType()
                        ));
                    } else {
                        // Unexpected behavior (just in case)
                        // something wrong if reach here
                        Log::info(sprintf(
                            'Unexpected message type has come, something wrong [class name: %s]',
                            get_class($event)
                        ));
                    }
                } elseif ($event instanceof JoinEvent) {
                    // $handler = new JoinEventHandler($event);
                } elseif ($event instanceof LeaveEvent) {
                    // $handler = new LeaveEventHandler($event);
                } elseif ($event instanceof PostbackEvent) {
                    // $handler = new PostbackEventHandler($event);
                } elseif ($event instanceof BeaconDetectionEvent) {
                    // $handler = new BeaconEventHandler($event);
                } elseif ($event instanceof AccountLinkEvent) {
                    // $handler = new AccountLinkEventHandler($event);
                } elseif ($event instanceof ThingsEvent) {
                    // $handler = new ThingsEventHandler($event);
                } elseif ($event instanceof UnknownEvent) {
                    Log::info(sprintf('Unknown message type has come [type: %s]', $event->getType()));
                } else {
                    // Unexpected behavior (just in case)
                    // something wrong if reach here
                    Log::info(sprintf(
                        'Unexpected event type has come, something wrong [class name: %s]',
                        get_class($event)
                    ));
                }
        */
    }
}
