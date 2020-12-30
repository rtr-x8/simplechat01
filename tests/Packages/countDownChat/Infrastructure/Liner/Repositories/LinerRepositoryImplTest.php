<?php

namespace Tests\Packages\countDownChat\Infrastructure\Liner\Repositories;

use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use CountDownChat\Infrastructure\Liner\Repositories\LinerRepositoryImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinerRepositoryImplTest extends TestCase
{
    use RefreshDatabase;

    private LinerRepository $linerRepository;

    /**
     * @test
     */
    public function 保存可能()
    {
        $linerModel = LinerModel::factory()->make();
        $liner = $linerModel->toDomain();
        $actual = $this->linerRepository->save($liner);

        $this->assertEquals($liner->getLinerId()->value(), $actual->getLinerId()->value());
    }

    /**
     * @test
     */
    public function 同一ID保存不可()
    {
        $this->expectException(ChatBotLogicException::class);

        $linerModel = LinerModel::factory()->make();
        $liner = $linerModel->toDomain();
        $this->linerRepository->save($liner);
        $this->linerRepository->save($liner);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->linerRepository = new LinerRepositoryImpl();
    }

    /**
     * @test
     */
    public function ラインIDで検索できる()
    {
        $linerModel = LinerModel::factory()->create();
        $liner = $linerModel->toDomain();
        $actual = $this->linerRepository->findByProviderId($liner->getProviderLinerId());

        $this->assertEquals($liner->getLinerId()->value(), $actual->getLinerId()->value());
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 存在しないラインIDで検索して例外()
    {
        $this->expectException(ChatBotLogicException::class);

        $this->linerRepository->findByProviderId('aa');
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function idで検索可能()
    {
        $linerId = LinerId::new();
        $linerModel = LinerModel::factory()->create([
            'liner_id' => $linerId->value()
        ]);

        $actual = $this->linerRepository->find($linerId);

        $this->assertEquals($linerId->value(), $actual->getLinerId()->value());
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 存在しないIDで検索して例外()
    {
        $this->expectException(ChatBotLogicException::class);

        $this->linerRepository->find(LinerId::of('this-is-test'));
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 更新可能()
    {
        $linerModel = LinerModel::factory()->create([
            'is_active' => true
        ]);
        $liner = $linerModel->toDomain();

        $updatedLiner = $this->linerRepository->update($liner, [
            'is_active' => false
        ]);

        $this->assertFalse($updatedLiner->isActive());

        $searched = $this->linerRepository->findByProviderId($liner->getProviderLinerId());

        $this->assertFalse($searched->isActive());
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 存在しないライナーを更新しようとして例外()
    {
        $this->expectException(ChatBotLogicException::class);

        $linerModel = LinerModel::factory()->make();
        $this->linerRepository->update($linerModel->toDomain(), [
            'is_active' => false
        ]);
    }

    /**
     * @test
     */
    public function アクティブなライナー一覧取得()
    {
        LinerModel::factory(8)->create(['is_active' => true]);
        LinerModel::factory(7)->create(['is_active' => false]);

        $results = $this->linerRepository->findActiveLiners();

        $this->assertCount(8, $results);
    }
}
