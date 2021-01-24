<?php


namespace CountDownChat\Domain\Message;

use LINE\LINEBot\MessageBuilder;

interface Message
{
    /**
     * @return MessageBuilder
     */
    public function get(): MessageBuilder;
}
