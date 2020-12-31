<?php


namespace CountDownChat\Infrastructure\EventHandler\Line;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Exception\InvalidEventSourceException;
use Shared\EventHandler\Line\LineEventHandler;

class UnfollowEventHandler implements LineEventHandler
{
    private BaseEvent $unFollowEvent;
    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;

    /**
     * UnfollowEventHandler constructor.
     * @param  LinerRepository  $linerRepository
     */
    public function __construct(
        LinerRepository $linerRepository
    ) {
        $this->linerRepository = $linerRepository;
    }

    /**
     * @inheritDoc
     */
    public function setEvent($event)
    {
        $this->unFollowEvent = $event;
        return $this;
    }

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function handle(): void
    {
        try {
            $liner = $this->linerRepository->findByProviderId($this->unFollowEvent->getEventSourceId());
            $this->linerRepository->update($liner, [
                'is_active' => false
            ]);
            \Log::info('ブロックされました。');
        } catch (ChatBotLogicException $e) {
            throw new ChatBotLogicException(
                '存在しないユーザーがブロックしました。',
                0,
                $e
            );
        } catch (InvalidEventSourceException $e) {
            throw new ChatBotLogicException(
                'なんかおかしい',
                0,
                $e
            );
        }
    }
}
