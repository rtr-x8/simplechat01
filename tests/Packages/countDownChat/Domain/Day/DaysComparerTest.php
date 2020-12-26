<?php


namespace Tests\Packages\countDownChat\Domain\Day;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use Tests\TestCase;

class DaysComparerTest extends TestCase
{
    /**
     * @test
     */
    public function ③日ずれてる()
    {
        $expected = 3;

        $before = Carbon::today();
        $after = $before->copy()->addDay($expected);
        $compare = DaysComparer::new($before, $after);

        $this->assertEquals($expected, $compare->getDiff());
    }

    /**
     * @test
     * @dataProvider compareData01
     *
     * @param  string  $before
     * @param  string  $after
     * @param  int  $expected
     */
    public function n日ずれてる(string $before, string $after, int $expected)
    {
        $before = Carbon::parse($before);
        $after = Carbon::parse($after);
        $compare = DaysComparer::new($before, $after);

        $this->assertEquals($expected, $compare->getDiff());
    }

    public function compareData01(): array
    {
        return [
            '10日差'  => ['2020-06-15', '2020-06-05', 10],
            '1日差'   => ['2020-06-15', '2020-06-14',  1],
            '0日差'   => ['2020-06-15', '2020-06-15',  0],
            '1日差2'  => ['2020-06-15', '2020-06-16',  1],
            '10日差2' => ['2020-06-15', '2020-06-25', 10],
            '4日差'   => ['2020-12-29', '2021-1-2', 4],
            'r0'   => ['2021-1-1', '2021-1-1', 0],
            'r1'   => ['2020-12-31', '2021-1-1', 1],
            'r2'   => ['2020-12-30', '2021-1-1', 2],
            'r-1'   => ['2021-1-2', '2021-1-1', 1],
        ];
    }

    /**
     * @test
     * @dataProvider compareData02
     *
     * @param  string  $before
     * @param  string  $after
     * @param  bool  $expected
     */
    public function 超過したか否か(string $before, string $after, bool $expected)
    {
        $before = Carbon::parse($before);
        $after = Carbon::parse($after);
        $compare = DaysComparer::new($before, $after);

        $this->assertEquals($expected, $compare->isExpired());
    }

    public function compareData02(): array
    {
        return [
            '超過してない1' => ['2020-6-20', '2020-6-30', false],
            '超過してない2' => ['2020-6-29', '2020-6-30', false],
            '超過した1' => ['2020-6-20', '2020-6-20', true],
            '超過した2' => ['2020-6-20', '2020-6-19', true],
            '超過した3' => ['2021-6-20', '2020-6-20', true],
            'r1' => ['2020-12-31', '2021-1-1', false],
            'r2' => ['2020-12-30', '2021-1-1', false],
            'r3' => ['2021-1-1', '2021-1-1', true],
            'r4' => ['2021-1-5', '2021-1-1', true],
        ];
    }
}
