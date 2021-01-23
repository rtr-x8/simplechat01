<?php


namespace CountDownChat\Infrastructure\EventHandler\Line;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\Services\DeadlineService;
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
    private DeadlineService $deadlineService;

    /**
     * FollowEventHandler constructor.
     * @param  LinerService  $linerService
     * @param  DeadlineService  $deadlineService
     */
    public function __construct(
        LinerService $linerService,
        DeadlineService $deadlineService
    ) {
        $this->linerService = $linerService;
        $this->deadlineService = $deadlineService;
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
        $liner = $this->linerService->createOrActivateLiner($providerId, $type);
        $deadline = $this->deadlineService->createDefaultDeadline($liner->getLinerId());
        $message = $this->createMessage($deadline);
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
     * @param  Deadline  $deadline
     * @return MessageBuilder
     */
    private function createMessage(Deadline $deadline): MessageBuilder
    {
        $greetingMessage = "こんにちは！\nカウントダウンチャットボットです！";
        $countdownMessage = CountDownMessageBuilder::new(today(), $deadline);
        return new TextMessageBuilder($greetingMessage, $countdownMessage->__toString());
    }
}
