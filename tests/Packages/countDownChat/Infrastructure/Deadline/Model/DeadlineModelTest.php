<?php


namespace Tests\Packages\countDownChat\Infrastructure\Deadline\Model;


use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;
use Tests\TestCase;

class DeadlineModelTest extends TestCase
{
    /**
     * @test
     */
    public function toDomain()
    {
        $deadlineModel = DeadlineModel::factory()->make();
        $deadline = $deadlineModel->toDomain();

        $this->assertEquals($deadlineModel->getKey(), $deadline->getDeadlineId()->value());
    }
}
