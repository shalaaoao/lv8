<?php

namespace App\Services\Card;

use App\Enum\CardEnum;

/**
 * 出牌规则校验
 * Class CardRulesVerifyServices
 * @package App\Services\Card
 */
class CardRulesVerifyServices
{
    protected array $cards;

    public function __construct(array $cards)
    {
        if (!$cards) {
            throw new \Exception('内部错误 - CardRulesVerifyServices初始化cards为空');
        }

        $this->cards = $cards;
        sort($this->cards);
    }

    /**
     * 查询出牌的类型
     * @return int[]
     */
    public function checkCardType(): array
    {
        $handle1  = new ConcreteVerify1();
        $handle1N = new ConcreteVerify1N();
        $handle2N = new ConcreteVerify2N();
        $handleN_M  = new ConcreteVerifyL_N_M();
        $handleBoom = new ConcreteVerifyBomb();
        $handleErr  = new ConcreteVerifyErr();

        $handle1->setSuccessor($handle1N);
        $handle1N->setSuccessor($handle2N);
        $handle2N->setSuccessor($handleN_M);
        $handleN_M->setSuccessor($handleBoom);
        $handleBoom->setSuccessor($handleErr);

        $obj = $handle1->verify($this->cards);
        if ($obj->cardType == CardEnum::CARD_TYPE_0) {
            throw new \Exception('错误的出牌类型');
        }

        // 反射获取类的属性 (主要是如果下面加了属性，这里不用跟着改)
        $lists = (new \ReflectionClass($obj))->getProperties(\ReflectionProperty::IS_PUBLIC);

        $res = [];
        foreach ($lists as $v) {
            $attrName       = $v->getName();
            $res[$attrName] = $obj->$attrName;
        }

        return $res;
    }
}

/**
 * 责任链 - 校验抽象基类
 * Class VerifyHandle
 * @package App\Services\Card
 */
abstract class VerifyHandle
{
    protected VerifyHandle $successor;

    public function setSuccessor(VerifyHandle $successor)
    {
        $this->successor = $successor;
    }

    /**
     * 分析出牌类型
     * @param array $cards
     * @return VerifyHandle
     */
    abstract public function verify(array $cards): VerifyHandle;

    /**
     * 比较大小
     * @param array $previous
     * @param array $current
     * @return int
     */
    abstract public function compare(array $previous, array $current): int;

    /**
     * 检查顺子，不针对长度做校验
     * @param array $cards
     * @return bool
     */
    protected function checkShunZa(array $cards): bool
    {
        foreach ($cards as $k => $cardNo) {

            // 不带1、2玩法
            if ($cardNo >= CardEnum::CARD_NO_14) {
                return false;
            }

            // 带大小王的 - 错
            if ($cardNo >= CardEnum::CARD_NO_15) {
                return false;
            }

            // 前后数字不连贯 - 错
            if (isset($cards[$k + 1]) && $cardNo != $cards[$k + 1] - 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * 出牌类型
     * @var int
     */
    public int $cardType;

    /**
     * 开始的牌
     * @var int
     */
    public int $startCardNo;

    /**
     * 连续的长度（顺子，飞机，连对）
     * @var int
     */
    public int $serialLen;

    /**
     * N带M的N，主体的长度
     * @var int
     */
    public int $commonLen = 0;

    /**
     * N带M的M，拖尾的长度
     * @var int
     */
    public int $additionalLen = 0;
}

/**
 * 单张
 * Class ConcreteVerify1
 * @package App\Services\Card
 */
class ConcreteVerify1 extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        if (count($cards) != 1) {
            return $this->successor->verify($cards);
        }

        $this->cardType    = CardEnum::CARD_TYPE_1;
        $this->startCardNo = $cards[0];
        $this->serialLen   = 1;

        return $this;
    }

    public function compare(array $previous, array $current): int
    {
        if ($current['startCardNo'] > $previous['startCardNo']) {
            return CardEnum::COMPARE_TRUE;
        }

        return CardEnum::COMPARE_FALSE;
    }
}

/**
 * 顺子
 * Class ConcreteVerify1N
 * @package App\Services\Card
 */
class ConcreteVerify1N extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        if (count($cards) < 5) {
            return $this->successor->verify($cards);
        }

        if (!$this->checkShunZa($cards)) {
            return $this->successor->verify($cards);
        }

        $this->cardType    = CardEnum::CARD_TYPE_1N;
        $this->startCardNo = $cards[0];
        $this->serialLen   = count($cards);

        return $this;
    }

    public function compare(array $previous, array $current): int
    {
        return CardEnum::COMPARE_FALSE;
    }
}

/**
 * 一对、连对
 * Class ConcreteVerify2N
 * @package App\Services\Card
 */
class ConcreteVerify2N extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        // 是否每个元素都只有2个
        $cardsValueCount = array_count_values($cards);
        $check           = collect($cardsValueCount)->filter(function ($item) {
            return $item != 2;
        })->count();
        if ($check) {
            return $this->successor->verify($cards);
        }

        $cardsUnique = array_unique($cards);

        // 一对的情况
        if (count($cardsUnique) == 1) {
            $this->cardType    = CardEnum::CARD_TYPE_2N;
            $this->startCardNo = $cards[0];
            $this->serialLen   = 1;
            return $this;
        }

        // 多对，检查是否是连对
        if (!$this->checkShunZa($cardsUnique)) {
            return $this->successor->verify($cards);
        }

        $this->cardType    = CardEnum::CARD_TYPE_2N;
        $this->startCardNo = $cards[0];
        $this->serialLen   = count($cardsUnique);
        return $this;
    }

    public function compare(array $previous, array $current): int
    {
        return CardEnum::COMPARE_FALSE;
    }
}

/**
 * 三张
 * Class ConcreteVerify1
 * @package App\Services\Card
 */
//class ConcreteVerify3 extends VerifyHandle
//{
//    public function verify(array $cards)
//    {
//        if (count($cards) != 3 || count(array_unique($cards)) != 1) {
//            return $this->successor->verify($cards);
//        }
//
//        return [CardEnum::CARD_TYPE_3, []];
//    }
//}

/**
 * 连续L个N带M，L>=1, N>=3, M<=N-1 (连续2个3带1)
 * Class ConcreteVerifyL_N_M
 * @package App\Services\Card
 */
class ConcreteVerifyL_N_M extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        $cardsValueCount = array_count_values($cards);
        $cardsN          = max($cardsValueCount);

        // N必须>=3
        if ($cardsN < 3) {
            return $this->successor->verify($cards);
        }

        // TODO L
        $cardsL = collect($cardsValueCount)->filter(function ($item) use ($cardsN) {
            return $item == $cardsN;
        })->count();

        // 判断M、N的数量是否都为L
        $cardsMCount = collect($cardsValueCount)->filter(function ($item) use ($cardsN) {
            return $item < $cardsN;
        })->count();
        $cardsMSum   = collect($cardsValueCount)->filter(function ($item) use ($cardsN) {
            return $item < $cardsN;
        })->sum();

        if ($cardsL != $cardsMCount && $cardsL != $cardsMSum) {
            return $this->successor->verify($cards);
        }

        // TODO 怎么获取M
        // TODO 抽象出N带M的问题，穷举1<=M<=N-1
        $cardsM = 0;

        // 判断M是否连续
        $cardsMList = collect($cardsValueCount)->filter(function ($item) use ($cardsN) {
            return $item == $cardsN;
        })->keys()->toArray();
        if (!$this->checkShunZa($cardsMList)) {
            return $this->successor->verify($cards);
        }

        return [CardEnum::CARD_TYPE_L_N_M, [$cardsL, $cardsN, $cardsM]];
    }

    public function compare(array $previous, array $current): int
    {
        return CardEnum::COMPARE_FALSE;
    }
}

/**
 * 炸弹
 * Class ConcreteVerifyBomb
 * @package App\Services\Card
 */
class ConcreteVerifyBomb extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        // 王炸、天王炸
        if (array_values(array_unique($cards)) == [CardEnum::CARD_NO_15, CardEnum::CARD_NO_16]) {
            $cardsCountValues = array_count_values($cards);
            if ($cardsCountValues[CardEnum::CARD_NO_15] == $cardsCountValues[CardEnum::CARD_NO_16]) {
                $this->cardType    = CardEnum::CARD_TYPE_BOMB;
                $this->startCardNo = $cards[0];
                $this->serialLen   = count($cards) * 2; // 一对大王+小王=4炸
                return $this;
            }
        }

        // 普通炸弹
        if (count(array_unique($cards)) == 1 && count($cards) >= 4) {
            $this->cardType    = CardEnum::CARD_TYPE_BOMB;
            $this->startCardNo = $cards[0];
            $this->serialLen   = count($cards);
            return $this;
        }

        return $this->successor->verify($cards);
    }

    public function compare(array $previous, array $current): int
    {
        return CardEnum::COMPARE_FALSE;
    }
}

/**
 * 异常
 * Class ConcreteVerify1
 * @package App\Services\Card
 */
class ConcreteVerifyErr extends VerifyHandle
{
    public function verify(array $cards): VerifyHandle
    {
        $this->cardType    = CardEnum::CARD_TYPE_0;
        $this->startCardNo = 0;
        $this->serialLen   = 0;

        return $this;
    }

    public function compare(array $previous, array $current): int
    {
        return CardEnum::COMPARE_ERROR;
    }
}
