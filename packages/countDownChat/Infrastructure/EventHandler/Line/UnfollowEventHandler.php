<?php


namespace CountDownChat\Infrastructure\EventHandler\Line;


use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use DB;
use LINE\LINEBot\Event\BaseEvent;
use Log;
use Shared\EventHandler\Line\LineEventHandler;
use Throwable;

class UnfollowEventHandler implements LineEventHandler
{
    private BaseEvent $unFollowEvent;
    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;
    /**
     * @var DeadlineRepository
     */
    private DeadlineRepository $deadlineRepository;

    /**
     * UnfollowEventHandler constructor.
     * @param  LinerRepository  $linerRepository
     * @param  DeadlineRepository  $deadlineRepository
     */
    public function __construct(
        LinerRepository $linerRepository,
        DeadlineRepository $deadlineRepository
    ) {
        $this->linerRepository = $linerRepository;
        $this->deadlineRepository = $deadlineRepository;
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
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::transaction(function () {
            // ライナーの非活性処理
            $liner = $this->linerRepository->findByProviderId($this->unFollowEvent->getEventSourceId());
            $this->linerRepository->update($liner, [
                'is_active' => false
            ]);

            // Deadlineの非活性処理
            $deadlines = $this->deadlineRepository->findByLinerId($liner->getLinerId());
            foreach ($deadlines as $deadline) {
                $this->deadlineRepository->update($deadline->getDeadlineId(), [
                    'is_active' => false
                ]);
            }

            Log::info('ブロックされました。', [
                'count deadline' => count($deadlines)
            ]);
        });

    }
}
