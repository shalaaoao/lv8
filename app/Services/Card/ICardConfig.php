<?php

namespace App\Services\Card;

/**
 * 基础配置、初始化相关接口
 * Interface ICardConfig
 * @package App\Services\Card
 */
interface ICardConfig
{
    /**
     * 设置牌的组成
     * @param int $packNum 几副牌
     * @return self
     */
    public function setCompose(int $packNum): self;

    /**
     * 设置玩家人数
     * @param int $num
     */
    public function setPlayerNum(int $num): self;

    /**
     * 设置玩家信息
     * @param int $playerNo
     * @param string $name
     */
    public function setPlayerInfo(int $playerNo, string $name): self;

    /**
     * 设置玩家角色
     * @param int $playerNo
     * @param int $role
     */
    public function setPlayerRole(int $playerNo, int $role): self;

    /**
     * 初始化玩家的牌
     * @param int $playerNo
     * @param array $cards
     * @return $this
     */
    public function initPlayerCards(int $playerNo, array $cards): self;

    /**
     * 增加玩家的牌
     * @param int $playerNo
     * @param array $cards
     * @return $this
     */
    public function addPlayerCards(int $playerNo, array $cards): self;

    /**
     * 出牌
     * @param int $playerNo
     * @param array $cards
     * @return $this
     */
    public function outPlayerCards(int $playerNo, array $cards): self;

    /**
     * 选择玩法
     * @param int $gameType
     */
    public function setGameType(int $gameType): self;

    /**
     * 设置底分
     * @param int $score
     */
    public function setBaseScore(int $score): self;

    /**
     * 设置积分翻倍条件
     * @param array $conditions
     */
    public function setDoubleCondition(array $conditions): self;

    /**
     * 设置出牌规则
     * @param array $rules
     */
    public function setPlayRulesConfig(array $rules): self;
}
