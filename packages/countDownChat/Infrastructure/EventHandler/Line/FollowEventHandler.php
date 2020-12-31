<?php


namespace CountDownChat\Infrastructure\EventHandler\Line;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Day\XDay;
use CountDownChat\Domain\Liner\LinerSourceType;
use CountDownChat\Domain\Liner\Services\LinerService;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Exception\InvalidEventSourceException;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINEBot;
use Shared\EventHandler\Line\LineEventHandler;

class FollowEventHandler implements LineEventHandler
{
    private BaseEvent $followEvent;
    private LinerService $linerService;

    /**
     * FollowEventHandler constructor.
     * @param  LinerService  $linerService
     */
    public function __construct(
        LinerService $linerService
    ) {
        $this->linerService = $linerService;
    }

    public function setEvent($event)
    {
        $this->followEvent = $event;
        return $this;
    }

    /**
     * @throws ChatBotLogicException
     */
    public function handle(): void
    {
        $type = $this->getSourceType();
        $providerId = $this->getEventSourceId();
        $this->linerService->createOrActivateLiner($providerId, $type);
        $message = $this->createMessage();
        LINEBot::replyMessage($this->followEvent->getReplyToken(), $message);
    }

    /**
     * @return LinerSourceType
     * @throws ChatBotLogicException
     */
    private function getSourceType(): LinerSourceType
    {
        if ($this->followEvent->isUserEvent()) {
            return LinerSourceType::User();
        } elseif ($this->followEvent->isGroupEvent()) {
            return LinerSourceType::Group();
        } elseif ($this->followEvent->isRoomEvent()) {
            return LinerSourceType::Room();
        }

        $error = new ChatBotLogicException(
            'Followイベントでソースタイプを検出できませんでした。',
            0,
            null
        );
        $error->report();
        throw $error;
    }

    /**
     * @return string
     * @throws ChatBotLogicException
     */
    private function getEventSourceId(): string
    {
        try {
            return $this->followEvent->getEventSourceId();
        } catch (InvalidEventSourceException $e) {
            $error = new ChatBotLogicException(
                '不正なイベントソースを取得しました',
                0,
                $e,
                [
                    'type' => $this->followEvent->getType()
                ]
            );
            $error->report();
            throw $error;
        }
    }

    /**
     * メッセージの作成
     *
     * @return MessageBuilder
     */
    private function createMessage(): MessageBuilder
    {
        $greetingMessage = "こんにちは！\n2020年をカウントダウンする、\nただのチャットボットです！";
        $countdownMessage = CountDownMessageBuilder::new(today(), XDay::new()->toCarbon());
        return new TextMessageBuilder($greetingMessage, $countdownMessage->__toString());
    }
}
