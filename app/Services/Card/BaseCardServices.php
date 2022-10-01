<?php

namespace App\Services\Card;

use App\Enum\CardEnum;

class BaseCardServices
{
    /**
     * 游戏类型
     * @var int
     */
    protected int $gameType;

    /**
     * 基础分
     * @var int
     */
    protected int $baseScore = 1;

    /**
     * 玩家信息
     * @var array
     */
    protected array $players = [];

    /**
     * 回合数
     * @var int
     */
    protected int $round = 1;

    /**
     * 几副牌
     * @var int
     */
    protected int $packNum = 1;

    /**
     * 卡牌池子
     * @var array
     */
    protected array $cardsPool = [];

    /**
     * 地主牌
     * @var array
     */
    protected array $lordCards = [];

    /**
     * 上一轮的出牌
     * @var array
     */
    protected array $previousCards = [];

    /**
     * 翻倍条件
     * @var array
     */
    protected array $doubleCondition = [];

    /**
     * 设置上一轮的出牌信息
     * @param array $cards
     * @return $this
     */
    public function setPreviousCards(array $cards): self
    {
        $this->previousCards = $cards;
        return $this;
    }

    /**
     * 比较牌的大小
     * @param array $tCards
     * @return int
     * @throws \Exception
     */
    public function compareCard(array $tCards): int
    {
        $previousInfo = (new CardRulesVerifyServices($this->previousCards))->checkCardType();
        $currentInfo  = (new CardRulesVerifyServices($tCards))->checkCardType();

        // 类型不同
        if ($previousInfo['cardType'] != $currentInfo['cardType']) {

            // 新出的牌不是炸弹 - 直接成功
            if ($currentInfo['cardType'] == CardEnum::CARD_TYPE_BOMB) {
                return CardEnum::COMPARE_TRUE;
            }

            // 错误
            return CardEnum::COMPARE_ERROR;
        }

        // 相同类型的情况
        switch($currentInfo['cardType']) {
            case CardEnum::CARD_TYPE_1:
                $className = ConcreteVerify1::class;
                break;
            case CardEnum::CARD_TYPE_1N:
                $className = ConcreteVerify1N::class;
                break;
            case CardEnum::CARD_TYPE_2N:
                $className = ConcreteVerify2N::class;
                break;
            case CardEnum::CARD_TYPE_L_N_M:
                $className = ConcreteVerifyL_N_M::class;
                break;
            case CardEnum::CARD_TYPE_BOMB:
                $className = ConcreteVerifyBomb::class;
                break;
            default:
                $className = ConcreteVerifyErr::class;
                break;
        }

        return (new $className)->compare($previousInfo, $currentInfo);
    }
}
