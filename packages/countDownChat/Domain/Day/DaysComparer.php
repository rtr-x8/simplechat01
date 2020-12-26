<?php


namespace CountDownChat\Domain\Day;


use Carbon\Carbon;
use DateInterval;

class DaysComparer
{
    private Carbon $beforeDay;
    private Carbon $afterDay;
    private DateInterval $diff;

    /**
     * CompareDays constructor.
     * @param  Carbon  $beforeDay
     * @param  Carbon  $afterDay
     */
    public function __construct(Carbon $beforeDay, Carbon $afterDay)
    {
        $this->beforeDay = $beforeDay;
        $this->afterDay = $afterDay;
        $this->diff = $beforeDay->diff($afterDay);
    }

    public static function new(Carbon $beforeDay, Carbon $afterDay): DaysComparer
    {
        return new static($beforeDay, $afterDay);
    }

    /**
     * @return int
     */
    public function getDiff()
    {
        return $this->diff->days;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->diff->invert > 0 || $this->getDiff() === 0;
    }
}
