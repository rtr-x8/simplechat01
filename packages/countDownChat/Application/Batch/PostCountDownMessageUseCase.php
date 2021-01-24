<?php


namespace CountDownChat\Application\Batch;


use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Message\DeadlinesMessage;
use LINEBot;
use Log;

/**
 * 1. アクティブなLinerとdeadlineを結号して取得
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
        $deadlineCounter = 0;
        foreach ($activeLiners as $liner) {
            $deadlines = $this->deadlineRepository->findByLinerId($liner->getLinerId());
            $activeDeadlines = collect($deadlines)->filter(function (Deadline $deadline) {
                return $deadline->isNotifiable();
            })->toArray();
            $message = new DeadlinesMessage($activeDeadlines);
            LINEBot::pushMessage($liner->getProviderLinerId(), $message->get());
            $deadlineCounter += count($activeDeadlines);
        }

        Log::info(__('count_down_bot.check_date.command.result', [
            'linerCount' => count($activeLiners),
            'deadlineCount' => $deadlineCounter
        ]));
    }

}
