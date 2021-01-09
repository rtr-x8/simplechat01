<?php


namespace CountDownChat\Infrastructure\Deadline\Repositories;


use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;

class DeadlineRepositoryImpl implements DeadlineRepository
{

    /**
     * @inheritDoc
     */
    public function save(Deadline $deadline): Deadline
    {
        $deadlineModel = DeadlineModel::fromDomain($deadline);
        $deadlineModel->save();
        return $deadlineModel->toDomain();
    }

    /**
     * @inheritDoc
     */
    public function findByLinerId(LinerId $linerId): array
    {
        $deadlineModels = DeadlineModel::query()
            ->where('liner_id', $linerId->value())
            ->get();

        return $deadlineModels->map(function (DeadlineModel $deadlineModel) {
            return $deadlineModel->toDomain();
        })->toArray();
    }
}
