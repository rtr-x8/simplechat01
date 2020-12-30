<?php


namespace CountDownChat\Domain\Liner\Repositories;


use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;

interface LinerRepository
{
    /**
     * 検索する。
     *
     * @param  LinerId  $linerId
     * @return Liner
     */
    public function find(LinerId $linerId): Liner;

    /**
     * 保存する
     *
     * @param  Liner  $liner
     * @return Liner
     */
    public function save(Liner $liner): Liner;

    /**
     * 更新する
     *
     * @param  Liner  $liner
     * @param  array  $array
     * @return Liner
     */
    public function update(Liner $liner, array $array): Liner;

    /**
     * LINEのIDから検索する
     *
     * @param  string  $key
     * @return Liner
     */
    public function findByProviderId(string $key): Liner;

    /**
     * アクティブなライナーを配列で取得する
     *
     * @return Liner[]
     */
    public function getActiveLiners(): array;
}
