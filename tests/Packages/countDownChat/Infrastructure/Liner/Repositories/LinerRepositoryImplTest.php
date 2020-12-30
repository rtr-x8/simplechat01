<?php

namespace Tests\Packages\countDownChat\Infrastructure\Liner\Repositories;

use App\Exceptions\ChatBotLogicException;
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
}
