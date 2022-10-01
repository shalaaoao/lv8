<?php

namespace App\Services\Card\Ddz;

use App\Enum\CardEnum;
use App\Services\Card\ICardAction;

class DdzActionServices extends DdzConfigServices implements ICardAction
{
    public function initGame(int $packNum, int $playerNum, int $baseScore): void
    {
        // TODO 干掉之前的游戏，初始化新的游戏

        $snap = $this->setGameType(CardEnum::GAME_TYPE_DDZ)
                     ->setCompose($packNum)
                     ->setPlayerNum($playerNum)
                     ->setBaseScore($baseScore)
                     ->setDoubleCondition();

        // TODO 快照入Cache
    }

    public function joinGame(int $playerNo, string $name): void
    {
        // TODO 获取快照Cache
        $snap = $this;

        $snap->setPlayerInfo($playerNo, $name);

        // TODO 快照入Cache
    }

    public function gameStart(): void
    {
        // TODO 获取快照Cache
        $snap = $this;

        shuffle($snap->cardsPool);

        // 拿出地主牌，并记录好
        $lordCards    = [];
        $lordCardsNum = CardEnum::getLordCardsNum(count($snap->players), $snap->packNum);
        for ($i = 0; $i < $lordCardsNum; $i++) {
            $lordCards[] = array_pop($snap->cardsPool);
        }
        $snap->setLordCards($lordCards);

        // 剩余牌分配给每个人
        $cardsChunk = array_chunk($snap->cardsPool, count($snap->players));
        foreach ($cardsChunk as $cards) {
            $snap->initPlayerCards($i, $cards);
        }

        // TODO 快照入Cache
    }

    public function setLord(int $lordPlayerNo): void
    {
        // TODO 获取快照Cache
        $snap = $this;

        // 设置玩家角色
        foreach ($snap->players as $playerNo => $info) {
            if ($playerNo == $lordPlayerNo) {
                $snap->setPlayerRole($lordPlayerNo, CardEnum::PLAYER_ROLE_LANDLORD);
            } else {
                $snap->setPlayerRole($playerNo, CardEnum::PLAYER_ROLE_FARMER);
            }
        }

        // TODO 快照入Cache
    }

    public function playCards(int $cardNo): void
    {
        // TODO: Implement playCards() method.
    }

    public function dealCards(): void
    {
        // TODO: Implement dealCards() method.
    }

    public function shuffleCards(): void
    {
        // TODO: Implement shuffleCards() method.
    }

    public function hint(): void
    {
        // TODO: Implement hint() method.
    }

    public function eliminate(): void
    {
        // TODO: Implement eliminate() method.
    }

    public function gameOver(): void
    {
        // TODO: Implement gameOver() method.
    }
}
