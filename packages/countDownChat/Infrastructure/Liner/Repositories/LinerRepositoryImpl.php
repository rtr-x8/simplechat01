<?php


namespace CountDownChat\Infrastructure\Liner\Repositories;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;

class LinerRepositoryImpl implements LinerRepository
{

    /**
     * @inheritDoc
     * @throws ChatBotLogicException
     */
    public function save(Liner $liner): Liner
    {
        try {
            $this->findByProviderId($liner->getProviderLinerId());
        } catch (ChatBotLogicException $e) {
            $linerModel = LinerModel::fromDomain($liner);
            $linerModel->save();
            return $linerModel->toDomain();
        }

        throw new ChatBotLogicException('保存しようとしたLinerのLINE IDが重複しました。', 0, null, [
            'line id' => $liner->getLinerId()->value()
        ]);
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
     */
    public function update(Liner $liner, array $array): Liner
    {
        $linerModel = LinerModel::fromDomain($liner);
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
}
