<?php


namespace CountDownChat\Domain\Liner\Services;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Domain\Liner\LinerSourceType;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;

class LinerService
{
    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;

    /**
     * LinerService constructor.
     * @param  LinerRepository  $linerRepository
     */
    public function __construct(
        LinerRepository $linerRepository
    ) {
        $this->linerRepository = $linerRepository;
    }

    /**
     * LINE IDとタイプを受け取って、検索を行う。存在すれば更新し、なければ作成する。
     *
     * @param  string  $linerSourceId
     * @param  LinerSourceType  $linerSourceType
     * @return Liner
     */
    public function createOrActivateLiner(string $linerSourceId, LinerSourceType $linerSourceType): Liner
    {
        try {
            $liner = $this->linerRepository->findByProviderId($linerSourceId);
            return $this->linerRepository->update($liner, [
                'is_active' => true
            ]);
        } catch (ChatBotLogicException $e) {
            $liner = new Liner(LinerId::new());
            $liner->setLinerSourceType($linerSourceType)
                ->setProviderLinerId($linerSourceId)
                ->setIsActive(true);
            return $this->linerRepository->save($liner);
        }
    }
}
