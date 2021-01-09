<?php


namespace Tests\Packages\countDownChat\Infrastructure\Deadline\Repositories;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Deadline\DeadlineId;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;
use CountDownChat\Infrastructure\Deadline\Repositories\DeadlineRepositoryImpl;
use CountDownChat\Infrastructure\Liner\Model\LinerModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeadlineRepositoryImplTest extends TestCase
{
    use RefreshDatabase;

    private DeadlineRepositoryImpl $deadLineRepository;

    /**
     * @test
     */
    public function 保存可能()
    {
        $linerModel = LinerModel::factory()->create();
        $deadlineModel = DeadlineModel::factory()->make([
            'liner_id' => $linerModel->getKey()
        ]);
        $deadline = $deadlineModel->toDomain();
        $actual = $this->deadLineRepository->save($deadline);

        $this->assertEquals($deadlineModel->getKey(), $actual->getDeadlineId()->value());
    }

    /**
     * @test
     */
    public function linerIDで検索()
    {
        $expected = 5;

        $linerModel = LinerModel::factory()->create();
        DeadlineModel::factory()->count($expected)->create([
            'liner_id' => $linerModel->getKey()
        ]);

        $deadlines = $this->deadLineRepository
            ->findByLinerId(LinerId::of($linerModel->getKey()));

        $this->assertCount($expected, $deadlines);
    }

    /**
     * @test
     */
    public function ないLinerIDで検索()
    {
        $deadlines = $this->deadLineRepository
            ->findByLinerId(LinerId::of(Str::uuid()));

        $this->assertCount(0, $deadlines);
    }

    /**
     * @test
     */
    public function 更新成功()
    {
        $expected = 'new name';

        $linerModel = LinerModel::factory()->create();
        $deadlineModel = DeadlineModel::factory()->create([
            'liner_id' => $linerModel->getKey()
        ]);
        $deadline = $deadlineModel->toDomain();

        $actual = $this->deadLineRepository->update($deadline->getDeadlineId(), [
            'name' => $expected
        ]);

        $this->assertEquals($expected, $actual->getName()->value());
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 更新しようとして例外()
    {
        $this->expectException(ChatBotLogicException::class);

        $this->deadLineRepository->update(DeadlineId::new(), [
            'name' => 'new name'
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->deadLineRepository = new DeadlineRepositoryImpl();
    }
}
