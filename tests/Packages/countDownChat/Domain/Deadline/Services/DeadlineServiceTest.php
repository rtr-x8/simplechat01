<?php


namespace Tests\Packages\countDownChat\Domain\Deadline\Services;


use Carbon\Carbon;
use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\DeadlineDescription;
use CountDownChat\Domain\Deadline\DeadlineId;
use CountDownChat\Domain\Deadline\DeadlineName;
use CountDownChat\Domain\Deadline\Services\DeadlineService;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Infrastructure\Deadline\Repositories\DeadlineRepositoryImpl;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use Tests\TestCase;

class DeadlineServiceTest extends TestCase
{
    /**
     * @test
     */
    public function デフォルト作成成功()
    {
        $linerModel = LinerModel::factory()->make();
        $linerId = LinerId::of($linerModel->getKey());

        $deadLine = new Deadline(DeadlineId::new());
        $deadLine
            ->setDeadlineAt(Carbon::parse('2022-01-01'))
            ->setIsComplete(false)
            ->setIsActive(true)
            ->setLinerId($linerId)
            ->setName(DeadlineName::of('2022年'))
            ->setDescription(DeadlineDescription::of('2022年までカウントダウンしています。良いことあると良いな'));

        $deadlineRepositoryMock = \Mockery::mock(DeadlineRepositoryImpl::class);
        $deadlineRepositoryMock
            ->shouldReceive('save')
            ->andReturn($deadLine);

        // ここまでモック

        $deadlineService = new DeadlineService($deadlineRepositoryMock);
        $actual = $deadlineService->createDefaultDeadline($linerId);

        $this->assertEquals($linerId->value(), $actual->getLinerId()->value());
        $this->assertEquals('2022年', $actual->getName()->value());
        $this->assertFalse($actual->isComplete());
        $this->assertTrue($actual->isActive());
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
