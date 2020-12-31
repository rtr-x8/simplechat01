<?php

namespace CountDownChat\Domain\Liner;

use App\Exceptions\ChatBotLogicException;
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

    /**
     * @param  string  $value
     * @return LinerSourceType
     * @throws ChatBotLogicException
     */
    public static function fromLineValue(string $value): LinerSourceType
    {
        switch ($value) {
            case 'user':
                return LinerSourceType::User();
            case 'group':
                return LinerSourceType::Group();
            case 'room':
                return LinerSourceType::Room();
            default:
                $error = new ChatBotLogicException(
                    '不明なソースタイプを検出しました。',
                    0,
                    null,
                    [
                        'value' => $value
                    ]
                );
                $error->report();
                throw $error;
        }
    }
}
