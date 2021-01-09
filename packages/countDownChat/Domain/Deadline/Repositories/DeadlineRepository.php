<?php


namespace CountDownChat\Domain\Deadline\Repositories;


use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Liner\LinerId;

interface DeadlineRepository
{
    /**
     * 作成
     *
     * @param  Deadline  $deadline
     * @return Deadline
     */
    public function save(Deadline $deadline): Deadline;

    /**
     * LinerIDによって検索
     *
     * @param  LinerId  $linerId
     * @return Deadline[]
     */
    public function findByLinerId(LinerId $linerId): array;
}
