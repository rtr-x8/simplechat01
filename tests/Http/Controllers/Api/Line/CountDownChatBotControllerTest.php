<?php

namespace Tests\Http\Controllers\Api\Line;

use Illuminate\Support\Facades\Config;
use LINE\LINEBot\Constant\HTTPHeader;
use Tests\TestCase;

class CountDownChatBotControllerTest extends TestCase
{
    /**
     * @test
     */
    public function リクエストヘッダがないと400エラー()
    {
        $res = $this->post('/api/line/countdown/callback');

        $res->assertStatus(400);
    }

    /**
     * @test
     */
    public function リクエストヘッダがあっても空なら400エラー()
    {
        $res = $this->withHeaders([
            HTTPHeader::LINE_SIGNATURE => ''
        ])
            ->post('/api/line/countdown/callback');

        $res->assertStatus(400);
    }

    /**
     * @test
     */
    public function 不正なリクエストヘッダで400エラー()
    {
        $res = $this->withHeaders([
            HTTPHeader::LINE_SIGNATURE => '不正なリクエストヘッダ'
        ])
            ->post('/api/line/countdown/callback');

        $res->assertStatus(400);
    }

    /**
     * そのうちやる
     */
    public function 正常なリクエストヘッダ()
    {
        $channelSecret = '9wygw2rxn6b8mfd65nurb7635edmk4p4';
        $content = 'this is content';

        Config::set('line-bot.channel_secret', $channelSecret);

        $signature = hash_hmac('sha256', $content, $channelSecret);
        // 0da5084c975a854acaab254ba517b860be5bf9a4b2d2fe41de8a66f8feab450a

        $res = $this->withHeaders([
            HTTPHeader::LINE_SIGNATURE => $signature
        ])
            ->post('/api/line/countdown/callback');

        $res->setContent($content)->assertStatus(200);
    }
}
