<?php

namespace App\Services\Card;

/**
 * 游戏动作相关接口
 * Interface ICardAction
 * @package App\Services\Card
 */
interface ICardAction
{
    /**
     * 初始化游戏
     * @param int $packNum 几副牌
     * @param int $playerNum 玩家人数
     * @param int $baseScore 底分
     */
    public function initGame(int $packNum, int $playerNum, int $baseScore): void;



    /**
     * 加入游戏
     * @param int $playerNo 玩家编号
     * @param string $name 玩家姓名
     */
    public function joinGame(int $playerNo, string $name): void;

    /**
     * 出牌
     * @param int $cardNo
     */
    public function playCards(int $cardNo): void;

    /**
     * 发牌
     */
    public function dealCards(): void;

    /**
     * 洗牌
     */
    public function shuffleCards(): void;

    /**
     * 提示
     */
    public function hint(): void;

    /**
     * 淘汰
     */
    public function eliminate(): void;

    /**
     * 游戏结束
     */
    public function gameOver(): void;
}
