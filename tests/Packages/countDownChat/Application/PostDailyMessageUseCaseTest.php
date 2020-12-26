<?php


namespace Tests\Packages\countDownChat\Application;


use CountDownChat\Application\Batch\PostDailyMessageUseCase;
use Exception;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PostDailyMessageUseCaseTest extends TestCase
{
    /**
     * @test
     * @throws Exception
     */
    public function 例外のテスト()
    {
        $this->expectException(Exception::class);
        $this->expectErrorMessage(__('count_down_bot.exception.expiredXDay'));

        Log::shouldReceive('critical')
            ->andReturn('');

        $today = now();
        $xDay = now();

        $useCase = new PostDailyMessageUseCase();
        $useCase->post($today, $xDay);
    }
}
