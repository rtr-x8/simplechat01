<?php


namespace Shared\EventHandler\Line;


/**
 * LINEからのイベントを処理する
 *
 * Interface LineEventHandler
 * @package Shared\EventHandler\Line
 */
interface LineEventHandler
{
    /**
     * イベントをセットします。
     * @param $event
     * @return mixed
     */
    public function setEvent($event);

    /**
     * イベントを処理します。
     */
    public function handle(): void;
}
