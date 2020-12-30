<?php


namespace CountDownChat\Infrastructure\Liner\Repositories;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinerRepositoryImpl implements LinerRepository
{

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function save(Liner $liner): Liner
    {
        $linerModel = LinerModel::fromDomain($liner);

        try {
            $linerModel->save();
            return $linerModel->toDomain();
        } catch (Exception $e) {
            throw new ChatBotLogicException(
                '保存しようとしたLinerのLINE IDが重複しました。',
                0,
                $e,
                [
                    'line id' => $liner->getLinerId()->value()
                ]
            );
        }
    }

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function findByProviderId(string $key): Liner
    {
        $linerModel = LinerModel::query()
            ->where('provided_liner_id', $key)
            ->first();
        if (is_null($linerModel)) {
            throw new ChatBotLogicException('ラインIDでLinerが見つかりませんでした。', 0, null, [
                'line id' => $key
            ]);
        }
        return $linerModel->toDomain();
    }

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function update(Liner $liner, array $array): Liner
    {
        $linerModel = LinerModel::query()->find($liner->getLinerId()->value());
        if (is_null($linerModel)) {
            throw new ChatBotLogicException('存在しないライナーを更新しようとしました。。',
                0,
                null,
                [
                    'line id' => $liner->getLinerId()->value()
                ]);
        }
        $linerModel->update($array);
        return $linerModel->toDomain();
    }

    /**
     * @inheritDoc
     */
    public function getActiveLiners(): array
    {
        $linerModels = LinerModel::query()
            ->where('is_active', true)
            ->get();

        return $linerModels->map(function (LinerModel $linerModel) {
            return $linerModel->toDomain();
        });
    }

    /**
     * @inheritDoc
     */
    public function find(LinerId $linerId): Liner
    {
        try {
            $linerModel = LinerModel::query()->findOrFail($linerId->value());
            return $linerModel->toDomain();
        } catch (ModelNotFoundException $e) {
            throw new ChatBotLogicException(
                'ライナーを検索できませんでした。',
                0,
                $e,
                [
                    'line id' => $linerId->value()
                ]
            );
        }
    }
}
