<?php


namespace CountDownChat\Application\Batch;


use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;

/**
 * 1. アクティブなLinerとdealineを結号して取得
 *
 * Class PostCountDownMessageUseCase
 * @package CountDownChat\Application\Batch
 */
class PostCountDownMessageUseCase
{
    /**
     * @var DeadlineRepository
     */
    private DeadlineRepository $deadlineRepository;

    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;


    /**
     * PostCountDownMessageUseCase constructor.
     * @param  LinerRepository  $linerRepository
     * @param  DeadlineRepository  $deadlineRepository
     */
    public function __construct(
        LinerRepository $linerRepository,
        DeadlineRepository $deadlineRepository
    ) {
        $this->deadlineRepository = $deadlineRepository;
        $this->linerRepository = $linerRepository;
    }
    /*
        public function post(): void
        {
            $activeLiners = $this->linerRepository->findActiveLiners();

            collect($activeLiners)->map(function (Liner $liner) {
                $deadlines = $this->deadlineRepository->findByLinerId($liner->getLinerId());
                collect($deadlines)->filter(function (Deadline $deadline) {
                    return $deadline->isNotifiable();
                })->map(function (Deadline $deadline) use ($liner) {
                    $message = CountDownMessageBuilder::new(
                        now(),
                        $deadline->getDeadlineAt()
                    )->__toString();
                    \LINEBot::pushMessage($liner->getProviderLinerId(), new TextMessageBuilder($message));
                });
            });
        }
    */
}
