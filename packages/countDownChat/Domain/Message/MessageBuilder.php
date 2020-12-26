<?php


namespace CountDownChat\Domain\Message;


use Carbon\Carbon;

interface MessageBuilder
{
    public static function new(Carbon $today, Carbon $xDay, int $diff): MessageBuilder;
}
