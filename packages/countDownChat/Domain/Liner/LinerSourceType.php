<?php

namespace CountDownChat\Domain\Liner;

use BenSampo\Enum\Enum;

/**
 * @method static static User()
 * @method static static Group()
 * @method static static Room()
 */
final class LinerSourceType extends Enum
{
    const User = 0;
    const Group = 1;
    const Room = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::User:
                return 'ユーザー';
            case self::Group:
                return 'グループ';
            case self::Room:
                return 'トークルーム';
            default:
                return parent::getDescription($value);
        }
    }
}
