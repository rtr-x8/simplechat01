<?php


namespace CountDownChat\Infrastructure\Message;


use Carbon\Carbon;
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

    public static function new(Carbon $today, Carbon $xDay, int $diff): CountDownMessageBuilder
    {
        $message = __('count_down_bot.hello') . PHP_EOL;
        $message .= __('count_down_bot.message.default', [
            'xDay' => $xDay->format(config('constants.format.date')),
            'day' => $diff
        ]) . PHP_EOL;
        return new static($message);
    }

    public function __toString(): string
    {
        return $this->message;
    }


}
