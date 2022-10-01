<?php

namespace App\Enum;

class CardEnum
{
    const GAME_TYPE_DDZ = 1; // 斗地主

    const CARD_NO_3  = 3; // 3
    const CARD_NO_12 = 12; // K
    const CARD_NO_13 = 13; // A
    const CARD_NO_14 = 14; // 2
    const CARD_NO_15 = 15; // 小王
    const CARD_NO_16 = 16; // 大王

    // 牌索引
    const CARDS_IDX = [
//        1  => '1',
//        2  => '2',
        3  => '3',
        4  => '4',
        5  => '5',
        6  => '6',
        7  => '7',
        8  => '8',
        9  => '9',
        10 => 'J',
        11 => 'Q',
        12 => 'K',
        13 => 'A',
        14 => '2',
        15 => 'Black Joker',
        16 => 'Red Joker',
    ];

    const CARD_TYPE_0     = 0;  // 错误
    const CARD_TYPE_1     = 1; // 单张
    const CARD_TYPE_1N    = 2; // 顺子
    const CARD_TYPE_2N    = 3; // 一对、连对
    const CARD_TYPE_L_N_M = 4; // 连续L个N带M，L>=1, N>=3, M<=N-1 (连续2个3带1)
    const CARD_TYPE_BOMB  = 5; // 炸弹

    // 比较牌大小
    const COMPARE_TRUE  = 1; // 大
    const COMPARE_FALSE = 2; // 小
    const COMPARE_ERROR = 3; // 错误

    /**
     * 获取一副牌的基础组成
     * @return array
     */
    public static function getPackCards()
    {
        $lists = array_keys(self::CARDS_IDX);
        $res   = [];
        foreach ($lists as $v) {
            if ($v == self::CARD_NO_15 || $v == self::CARD_NO_16) {
                $padSize = 1;
            } else {
                $padSize = 4;
            }
            $res = array_merge($res, array_pad([], $padSize, $v));
        }

        return $res;
    }

    // 角色
    const PLAYER_ROLE_FARMER   = 1; // 农民
    const PLAYER_ROLE_LANDLORD = 2; // 地主

    // 翻倍条件
    const BOMB_4    = 1; // >=4个炸弹
    const BOMB_5    = 2; // >=5个炸弹
    const SPRING    = 3; // 春天
    const SHOW_CARD = 4; // 明牌

    /**
     * 获取默认的翻倍条件
     * @param int $packNum
     * @return int[]
     */
    public static function defaultDoubleCondition(int $packNum): array
    {
        $res = [
            self::SPRING,
            self::SHOW_CARD,
        ];

        if ($packNum == 1) {
            $res[] = self::BOMB_4;
        }

        if ($packNum > 1) {
            $res[] = self::BOMB_5;
        }

        return $res;
    }

    /**
     * 地主牌的数量
     * @param int $playerNum
     * @param int $packNum
     * @return int
     */
    public static function getLordCardsNum(int $playerNum, int $packNum): int
    {
        return $playerNum * $packNum;
    }
}
