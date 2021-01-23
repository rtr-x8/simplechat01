<?php


namespace CountDownChat\Domain\Message;


use Carbon\Carbon;
use CountDownChat\Domain\Deadline\Deadline;

interface MessageBuilder
{
    public static function new(Carbon $today, Deadline $deadline): MessageBuilder;
}
