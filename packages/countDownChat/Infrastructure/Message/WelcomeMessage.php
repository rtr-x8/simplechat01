<?php


namespace CountDownChat\Infrastructure\Message;


use CountDownChat\Domain\Message\Message;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class WelcomeMessage implements Message
{
    private string $message;

    /**
     * WelcomeMessage constructor.
     */
    public function __construct()
    {
        $hello = __('count_down_bot.hello');
        $welcome = __('count_down_bot.welcome');
        $introduction = __('count_down_bot.introduction');
        $this->message = $hello.PHP_EOL.$welcome.PHP_EOL.$introduction;
    }

    public function get(): MessageBuilder
    {
        return new TextMessageBuilder($this->message);
    }
}
