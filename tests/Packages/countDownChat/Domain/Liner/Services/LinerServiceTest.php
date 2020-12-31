<?php


namespace Tests\Packages\countDownChat\Domain\Liner\Services;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Domain\Liner\Services\LinerService;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use Tests\TestCase;

class LinerServiceTest extends TestCase
{
    /**
     * @test
     */
    public function 存在しなければ作成()
    {
        $linerModel = LinerModel::factory()->make();
        $liner = $linerModel->toDomain();

        $repositoryMock = \Mockery::mock(LinerRepository::class);
        $repositoryMock
            ->shouldReceive('findByProviderId')
            ->andThrow(ChatBotLogicException::class);
        $repositoryMock
            ->shouldReceive('save')
            ->andReturn($liner);

        $service = new LinerService($repositoryMock);
        $actual = $service->createOrActivateLiner($liner->getProviderLinerId(), $liner->getLinerSourceType());

        $this->assertEquals(
            $liner->getLinerId()->value(),
            $actual->getLinerId()->value()
        );
    }

    /**
     * @test
     */
    public function 存在すれば更新()
    {
        $linerModel = LinerModel::factory()->make([
            'is_active' => false
        ]);
        $liner = $linerModel->toDomain();

        $repositoryMock = \Mockery::mock(LinerRepository::class);
        $repositoryMock
            ->shouldReceive('findByProviderId')
            ->andReturn($liner);

        $liner->setIsActive(true);
        $repositoryMock
            ->shouldReceive('update')
            ->andReturn($liner);

        $service = new LinerService($repositoryMock);
        $actual = $service->createOrActivateLiner($liner->getProviderLinerId(), $liner->getLinerSourceType());

        $this->assertEquals(
            $liner->getLinerId()->value(),
            $actual->getLinerId()->value()
        );

        $this->assertTrue($actual->isActive());
    }
}
