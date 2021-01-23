<?php


namespace CountDownChat\Infrastructure\EventHandler\Line\MessageHandler;


use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINEBot;
use Shared\EventHandler\Line\LineEventHandler;

class TextMessageHandler implements LineEventHandler
{
    private BaseEvent $textMessageEvent;

    /**
     * @inheritDoc
     */
    public function setEvent($event)
    {
        $this->textMessageEvent = $event;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        $messageBuilder = new TextMessageBuilder(__('count_down_bot.hello'));
        LINEBot::replyMessage($this->textMessageEvent->getReplyToken(), $messageBuilder);
    }
}
