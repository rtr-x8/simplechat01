<?php


namespace CountDownChat\Application\Batch;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use CountDownChat\Domain\Liner\LinerSourceType;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Message\CountDownMessageBuilder;
use Exception;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINEBot;
use Log;

class PostDailyMessageUseCase
{
    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;

    /**
     * PostDailyMessageUseCase constructor.
     * @param  LinerRepository  $linerRepository
     */
    public function __construct(
        LinerRepository $linerRepository
    ) {
        $this->linerRepository = $linerRepository;
    }


    /**
     * @param  Carbon  $today
     * @param  Carbon  $xDay
     * @throws Exception
     */
    public function post(Carbon $today, Carbon $xDay)
    {
        $compare = DaysComparer::new($today, $xDay);
        $format = config('constants.format.date');
        if ($compare->isExpired()) {
            Log::critical(__('count_down_bot.exception.expiredXDay', [
                __('count_down_bot.chara.today') => $today->format($format),
                __('count_down_bot.chara.executed_day') => $today->format($format),
                __('count_down_bot.chara.x_day') => $xDay->format($format)
            ]));
            throw new Exception(__('count_down_bot.exception.expiredXDay'));
        }
        $message = CountDownMessageBuilder::new($today, $xDay, $compare->getDiff())->__toString();
        $messageBuilder = new TextMessageBuilder($message);
        $liners = $this->linerRepository->findActiveLiners();

        $userIds = [];
        foreach ($liners as $liner) {
            if ($liner->getLinerSourceType()->is(LinerSourceType::User())) {
                $userIds[] = $liner->getProviderLinerId();
            } else {
                LINEBot::pushMessage($liner->getProviderLinerId(), $messageBuilder);
            }
        }
        LINEBot::multicast($userIds, $messageBuilder);

        Log::info(count($liners)."人のユーザーやグループにメッセージを送りました。", [
            '文言' => $message
        ]);
    }
}
