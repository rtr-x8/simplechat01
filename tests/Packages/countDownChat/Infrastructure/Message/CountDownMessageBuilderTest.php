<?php


namespace Tests\Packages\countDownChat\Infrastructure\Message;


use Carbon\Carbon;
use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
use Tests\TestCase;

class CountDownMessageBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function 良い感じ()
    {
        $today = Carbon::parse('2020-12-1');
        $deadlineModel = DeadlineModel::factory()->make([
            'deadline_at' => Carbon::parse('2021-1-1')
        ]);
        $deadline = $deadlineModel->toDomain();
        $message = CountDownMessageBuilder::new($today, $deadline);

        $expected = "{$deadlineModel->name}まで、".PHP_EOL."あと31日です。";

        $this->assertEquals($expected, $message->__toString());
    }
}
