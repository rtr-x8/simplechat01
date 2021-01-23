<?php

namespace Database\Seeders;

use CountDownChat\Domain\Deadline\Services\DeadlineService;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use Illuminate\Database\Seeder;

/**
 * Deadline作成時に、既存ユーザーの情報からモデルを作成するために作成
 *
 * Class TransferXDayToDeadlineSeeder
 * @package Database\Seeders
 */
class TransferXDayToDeadlineSeeder extends Seeder
{
    /**
     * @var DeadlineService
     */
    private DeadlineService $deadlineService;
    /**
     * @var LinerRepository
     */
    private LinerRepository $linerRepository;

    /**
     * TransferXDayToDeadlineSeeder constructor.
     * @param  LinerRepository  $linerRepository
     * @param  DeadlineService  $deadlineService
     */
    public function __construct(
        LinerRepository $linerRepository,
        DeadlineService $deadlineService
    ) {
        $this->linerRepository = $linerRepository;
        $this->deadlineService = $deadlineService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $liners = $this->linerRepository->findActiveLiners();

        foreach ($liners as $liner) {
            $this->deadlineService->createDefaultDeadline($liner->getLinerId());
        }

        \Log::info('TransferXDayToDeadlineSeeder is success');
    }
}
