<?php


namespace Tests\Packages\countDownChat\Infrastructure\Message;


use Carbon\Carbon;
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
        $xDay = Carbon::parse('2021-1-1');
        $diff = $today->diff($xDay);
        $message = CountDownMessageBuilder::new($today, $xDay, $diff->days);

        $expected = '2021年1月1日まで、'.PHP_EOL.'あと31日です。';

        $this->assertEquals($expected, $message->__toString());
    }
}
