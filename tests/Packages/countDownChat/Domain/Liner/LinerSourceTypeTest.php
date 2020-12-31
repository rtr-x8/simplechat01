<?php


namespace Tests\Packages\countDownChat\Domain\Liner;


use App\Exceptions\ChatBotLogicException;
use CountDownChat\Domain\Liner\LinerSourceType;

class LinerSourceTypeTest extends \Tests\TestCase
{
    /**
     * @test
     * @dataProvider textData
     * @param  string  $lineValue
     * @param  int  $value
     * @throws ChatBotLogicException
     */
    public function 文字列から取得(string $lineValue, int $value)
    {
        $type = LinerSourceType::fromLineValue($lineValue);

        $this->assertEquals($value, $type->value);
    }

    public function textData(): array
    {
        return [
            'user' => ['user', 0],
            'group' => ['group', 1],
            'room' => ['room', 2]
        ];
    }

    /**
     * @test
     * @throws ChatBotLogicException
     */
    public function 該当しない文字列で例外()
    {
        $this->expectException(ChatBotLogicException::class);

        LinerSourceType::fromLineValue('useraaa');
    }
}
