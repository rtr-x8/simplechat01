<?php


namespace CountDownChat\Infrastructure\Message;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Message\MessageBuilder;

class CountDownMessageBuilder
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

    public static function new(Carbon $today, Deadline $deadline): CountDownMessageBuilder
    {
        $diff = DaysComparer::new($today, $deadline->getDeadlineAt());
        $message = __('count_down_bot.message.default', [
            'xDay' => $deadline->getName(),
            'day' => $diff->getDiff()
        ]);
        return new static($message);
    }

    public function __toString(): string
    {
        return $this->message;
    }

    public function toString(): string
    {
        return $this->__toString();
    }


}
