<?php


namespace CountDownChat\Infrastructure\EventHandler\Line\MessageHandler;


use CountDownChat\Domain\Day\XDay;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
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
        $countdownMessage = CountDownMessageBuilder::new(today(), XDay::new()->toCarbon());
        $messageBuilder = new TextMessageBuilder($countdownMessage->__toString());
        LINEBot::replyMessage($this->textMessageEvent->getReplyToken(), $messageBuilder);
    }
}
