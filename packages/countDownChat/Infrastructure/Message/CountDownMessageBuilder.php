<?php


namespace CountDownChat\Infrastructure\Message;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use CountDownChat\Domain\Message\MessageBuilder;

class CountDownMessageBuilder implements MessageBuilder
{
    private string $message;

    /**
     * CountDownMessageBuilder constructor.
     * @param  string  $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function new(Carbon $today, Carbon $xDay, int $diff = null): CountDownMessageBuilder
    {
        $diff = is_null($diff) ? DaysComparer::new($today, $xDay)->getDiff() : $diff;
        $message = __('count_down_bot.message.default', [
            'xDay' => $xDay->format(config('constants.format.date')),
            'day' => $diff
        ]);
        return new static($message);
    }

    public function __toString(): string
    {
        return $this->message;
    }


}
