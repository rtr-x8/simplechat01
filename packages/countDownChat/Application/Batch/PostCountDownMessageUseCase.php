<?php


namespace CountDownChat\Application\Batch;


use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINEBot;

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

    public function post(): void
    {
        // activeなLinerを取得
        $activeLiners = $this->linerRepository->findActiveLiners();

        // ライナーに紐づくactiveなDeadlineを通知する
        foreach ($activeLiners as $liner) {
            $deadlines = $this->deadlineRepository->findByLinerId($liner->getLinerId());
            $activeDeadlines = collect($deadlines)->filter(function (Deadline $deadline) {
                return $deadline->isNotifiable();
            })->toArray();
            foreach ($activeDeadlines as $deadline) {
                $message = CountDownMessageBuilder::new(
                    now(),
                    $deadline->getDeadlineAt()
                )->__toString();
                LINEBot::pushMessage($liner->getProviderLinerId(), new TextMessageBuilder($message));
            }
        }
    }

}
