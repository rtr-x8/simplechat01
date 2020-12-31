<?php


namespace Tests\Packages\countDownChat\Application;


use CountDownChat\Application\Batch\PostDailyMessageUseCase;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use Exception;
use Log;
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

        $repositoryMock = \Mockery::mock(LinerRepository::class);
        $repositoryMock
            ->shouldReceive('findActiveLiners')
            ->andReturn([]);

        $useCase = new PostDailyMessageUseCase($repositoryMock);
        $useCase->post($today, $xDay);
    }
}
