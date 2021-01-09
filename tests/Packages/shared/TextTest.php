<?php


namespace Tests\Packages\shared;


use Shared\Domain\Text;
use Tests\TestCase;

class TextTest extends TestCase
{
    /**
     * @test
     */
    public function 同一の文字列()
    {
        $val1 = Text::of('test');
        $val2 = Text::of('test');

        $this->assertTrue($val1->equals($val2));
    }

    /**
     * @test
     * @dataProvider invalidData
     * @param  string  $val1
     * @param  string  $val2
     */
    public function 同一でない文字列(string $val1, string $val2)
    {
        $v1 = Text::of($val1);
        $v2 = Text::of($val2);

        $this->assertFalse($v1->equals($v2));
    }

    /**
     * @return array
     */
    public function invalidData(): array
    {
        return [
            '改行あり' => [
                'あいうえお',
                "あいう\nえお"
            ],
            '普通に違う1' => [
                'アイウエオ',
                'かきくけこ',
            ]
        ];
    }
}
