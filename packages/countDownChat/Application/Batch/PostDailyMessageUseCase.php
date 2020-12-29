<?php


namespace CountDownChat\Application\Batch;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
use Exception;
use Illuminate\Support\Facades\Log;

class PostDailyMessageUseCase
{

    /**
     * @param  Carbon  $today
     * @param  Carbon  $xDay
     * @throws Exception
     */
    public function post(Carbon $today, Carbon $xDay)
    {
        $compare = DaysComparer::new($today, $xDay);
        if($compare->isExpired()) {
            Log::critical(__('count_down_bot.exception.expiredXDay'));
            throw new Exception(__('count_down_bot.exception.expiredXDay'));
        }
        $message = CountDownMessageBuilder::new($today, $xDay, $compare->getDiff());
        Log::info($message->__toString());
    }
}
