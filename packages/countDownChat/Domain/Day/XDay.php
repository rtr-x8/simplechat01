<?php


namespace CountDownChat\Domain\Day;


use Carbon\Carbon;

/**
 * Class XDay
 * その日について示す。そう、つまりカウントダウンがゼロになる日だ。
 *
 * @package CountDownChat\Domain\Day
 */
class XDay
{
    private string $xDay = '2022/01/01 00:00:00';

    public static function new(): XDay
    {
        return new static();
    }

    public function toString(): string
    {
        return $this->xDay;
    }

    public function toCarbon(): Carbon
    {
        return Carbon::parse($this->xDay);
    }
}
