<?php

namespace App\Console\Commands;

use CountDownChat\Application\Batch\PostDailyMessageUseCase;
use CountDownChat\Domain\Day\XDay;
use Exception;
use Illuminate\Console\Command;
use Log;

class CheckDateCommand extends Command
{
    private PostDailyMessageUseCase $postMessageUseCase;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:checkdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '日付を計算して指定日までの日数を計算します';

    /**
     * Create a new command instance.
     *
     * @param  PostDailyMessageUseCase  $postMessageUseCase
     */
    public function __construct(
        PostDailyMessageUseCase $postMessageUseCase
    ) {
        parent::__construct();
        $this->postMessageUseCase = $postMessageUseCase;
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {

        $today = now();
        $xDay = XDay::new()->toCarbon();
        $format = config('constants.format.date');

        Log::info(__('count_down_bot.check_date.command.executed'), [
            __('count_down_bot.chara.today') => $today->format($format),
            __('count_down_bot.chara.executed_day') => $today->format($format),
            __('count_down_bot.chara.x_day') => $xDay->format($format)
        ]);

        $this->postMessageUseCase->post($today, $xDay);
    }
}
