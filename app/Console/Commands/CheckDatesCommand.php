<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use CountDownChat\Application\Batch\PostDailyMessageUseCase;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckDatesCommand extends Command
{
    private PostDailyMessageUseCase $postMessageUseCase;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:checkdates {today} {xDay}';

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
        $today = Carbon::parse($this->argument('today'));
        $xDay = Carbon::parse($this->argument('xDay'));

        $debugMessage = "Count-down command executed. today: {$today}, xDay: {$xDay}";
        $this->info($debugMessage);
        Log::info($debugMessage);

        $this->postMessageUseCase->post($today, $xDay);
    }
}
