<?php


namespace Tests\Packages\countDownChat\Domain\Deadline;


use Carbon\Carbon;
use CountDownChat\Infrastructure\Deadline\Model\DeadlineModel;
use Tests\TestCase;

class DeadlineTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     * @param  bool  $active
     * @param  bool  $complete
     * @param  Carbon  $xDay
     */
    public function 通知可能(bool $active, bool $complete, Carbon $xDay)
    {
        // dd(today(), ", ", today()->addHour());
        $deadlineModel = DeadlineModel::factory()->make([
            'is_active' => $active,
            'is_complete' => $complete,
            'deadline_at' => $xDay
        ]);
        $deadline = $deadlineModel->toDomain();

        $this->assertTrue($deadline->isNotifiable());
    }

    public function validData(): array
    {
        return [
            [true, false, now()->addDay()],
            [true, false, now()->addSecond()],
            [true, false, now()->addHour()],
            [true, false, now()->addMinute()],
        ];
    }

    /**
     * @test
     * @dataProvider inValidData
     * @param  bool  $active
     * @param  bool  $complete
     * @param  Carbon  $xDay
     */
    public function 通知不可能(bool $active, bool $complete, Carbon $xDay)
    {
        // dd(today(), ", ", today()->addHour());
        $deadlineModel = DeadlineModel::factory()->make([
            'is_active' => $active,
            'is_complete' => $complete,
            'deadline_at' => $xDay
        ]);
        $deadline = $deadlineModel->toDomain();

        $this->assertFalse($deadline->isNotifiable());
    }

    public function inValidData(): array
    {
        return [
            '#1' => [true, false, now()->subDay()],
            '#2' => [true, false, now()->subDays(5)],
            '#3' => [true, true, now()->addDay()],
            '#4' => [true, true, now()->subDay()],
            '#5' => [true, true, now()->subDays(5)],
            '#6' => [false, false, now()->subDay()],
            '#7' => [false, false, now()->addDay()],
            '#8' => [false, false, now()->subDays(5)],
        ];
    }

}
