<?php


namespace CountDownChat\Infrastructure\Deadline\Repositories;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\DeadlineId;
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

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function update(DeadlineId $deadlineId, array $array): Deadline
    {
        $deadlineModel = DeadlineModel::query()->find($deadlineId->value());
        if (is_null($deadlineModel)) {
            $error = new ChatBotLogicException(
                '存在しないデッドラインを更新しようとしました。。',
                0,
                null,
                [
                    'Deadline id' => $deadlineId->value()
                ]
            );
            $error->report();
            throw $error;
        }
        $deadlineModel->update($array);
        return $deadlineModel->toDomain();
    }
}
