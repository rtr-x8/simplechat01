<?php


namespace CountDownChat\Domain\Deadline\Services;


use Carbon\Carbon;
use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\DeadlineDescription;
use CountDownChat\Domain\Deadline\DeadlineId;
use CountDownChat\Domain\Deadline\DeadlineName;
use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\LinerId;

class DeadlineService
{
    /**
     * @var DeadlineRepository
     */
    private DeadlineRepository $deadlineRepository;

    /**
     * DeadlineService constructor.
     * @param  DeadlineRepository  $deadlineRepository
     */
    public function __construct(
        DeadlineRepository $deadlineRepository
    ) {
        $this->deadlineRepository = $deadlineRepository;
    }

    public function createDefaultDeadline(LinerId $linerId): Deadline
    {
        $deadLine = new Deadline(DeadlineId::new());
        $deadLine
            ->setDeadlineAt(Carbon::parse('2022-01-01'))
            ->setIsComplete(false)
            ->setIsActive(true)
            ->setLinerId($linerId)
            ->setName(DeadlineName::of('2022年'))
            ->setDescription(DeadlineDescription::of('2022年までカウントダウンしています。良いことあると良いな'));
        return $this->deadlineRepository->save($deadLine);
    }
}
