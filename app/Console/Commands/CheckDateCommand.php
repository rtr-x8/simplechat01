<?php

namespace App\Console\Commands;

use CountDownChat\Application\Batch\PostCountDownMessageUseCase;
use Exception;
use Illuminate\Console\Command;
use Log;

class CheckDateCommand extends Command
{
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
    protected $description = 'Deadlineを通知します。';
    private PostCountDownMessageUseCase $postCountDownMessageUseCase;

    /**
     * Create a new command instance.
     *
     * @param  PostCountDownMessageUseCase  $postCountDownMessageUseCase
     */
    public function __construct(
        PostCountDownMessageUseCase $postCountDownMessageUseCase
    ) {
        parent::__construct();
        $this->postCountDownMessageUseCase = $postCountDownMessageUseCase;
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
        $format = config('constants.format.systemDate');

        Log::info(__('count_down_bot.check_date.command.executed', [
            'datetime' => $today->format($format),
        ]));

        $this->postCountDownMessageUseCase->post();
    }
}
