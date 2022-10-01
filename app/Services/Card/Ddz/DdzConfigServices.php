<?php

namespace App\Services\Card\Ddz;

use App\Enum\CardEnum;
use App\Services\Card\BaseCardServices;
use App\Services\Card\ICardConfig;

class DdzConfigServices extends BaseCardServices implements ICardConfig
{
    public function setCompose(int $packNum): self
    {
        if ($packNum < 1) {
            throw new \Exception('最少一副牌');
        }

        if ($packNum > 4) {
            throw new \Exception('目前斗地主仅支持最多4副牌打法');
        }

        $this->packNum = $packNum;

        // 斗地主保留完整牌
        $packDetail = CardEnum::getPackCards();

        $res = [];
        for ($i = 0; $i < $packNum; $i++) {
            $res = array_merge($res, $packDetail);
        }

        $this->cardsPool = $res;

        return $this;
    }

    public function setPlayerNum(int $num): self
    {
        if ($num < 3 || $num > 4) {
            throw new \Exception('斗地主人数限制为3-4人');
        }

        for ($i = 0; $i < $num; $i++) {
            $this->players[$i] = [
                'name'  => '', // 姓名
                'role'  => CardEnum::PLAYER_ROLE_FARMER, // 角色，默认农民
                'cards' => [], // 剩余卡片
            ];
        }

        return $this;
    }

    public function setPlayerInfo(int $playerNo, string $name): self
    {
        $this->players[$playerNo]['name'] = $name;

        return $this;
    }

    public function setPlayerRole(int $playerNo, int $role): self
    {
        $this->players[$playerNo]['role'] = $role;

        return $this;
    }

    public function initPlayerCards(int $playerNo, array $cards): self
    {
        $this->players[$playerNo]['cards'] = $cards;

        return $this;
    }

    public function addPlayerCards(int $playerNo, array $cards): self
    {
        $oriCards = $this->players[$playerNo]['cards'];
        $mCards = array_merge($oriCards, $cards);
        shuffle($mCards);

        $this->players[$playerNo]['cards'] = $mCards;

        return $this;
    }

    public function outPlayerCards(int $playerNo, array $cards): self
    {
        foreach ($this->players[$playerNo]['cards'] as $k => $cardNo) {
            if (in_array($cardNo, $cards)) {
                unset($this->players[$playerNo]['cards'][$k]);
            }
        }

        foreach ($cards as $k => $cardNo) {
            if (in_array($cardNo, $this->players[$playerNo]['cards'])) {
                unset($cardNo[$k]);
            }
        }
    }

    public function setGameType(int $gameType): self
    {
        $this->gameType = $gameType;

        return $this;
    }

    public function setBaseScore(int $score): self
    {
        $this->baseScore = $score;

        return $this;
    }

    public function setDoubleCondition(array $conditions = []): self
    {
        $this->doubleCondition = CardEnum::defaultDoubleCondition($this->packNum);

        return $this;
    }

    public function setPlayRulesConfig(array $rules): self
    {
        // TODO: Implement setPlayRulesConfig() method.
    }

    /**
     * 设置地主牌
     * @param array $cards
     * @return $this
     */
    public function setLordCards(array $cards): self
    {
        $this->lordCards = $cards;

        return $this;
    }
}
