<?php


namespace Tests\Packages\countDownChat\Infrastructure\Message;


use CountDownChat\Infrastructure\Message\WelcomeMessage;
use Tests\TestCase;

class WelcomeMessageTest extends TestCase
{
    /**
     * @test
     */
    public function メッセージ作成()
    {
        $build = new WelcomeMessage();
        $message = $build->get();

        $this->assertEquals(
            "こんにちは。\n友達登録ありがとう！\nカウントダウンBOTです！",
            $message->buildMessage()[0]['text']
        );
    }
}
