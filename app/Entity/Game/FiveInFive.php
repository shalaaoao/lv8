<?php

namespace App\Entity\Game;

class FiveInFive
{
    // 棋盘
    private array $chessboard = [];

    // 棋局明细
    private array $procedure = [];

    const COLOR_BLACK = 1; // 黑子
    const COLOR_WHITE = 2; // 白子

    private FiveInFiveImage $fiveInFiveImage;

    public function __construct(string $uuid)
    {
        $this->fiveInFiveImage = new FiveInFiveImage($uuid);
    }

    private function initChessboard()
    {
        for ($i = 0; $i < 15; $i++) {
            $this->chessboard[$i] = [];
            for ($j = 0; $j < 15; $j++) {
                $this->chessboard[$i][$j] = 0;
            }
        }
    }

    public function getChessboard(): array
    {
        return $this->chessboard;
    }

    public function getLastProducer(): array
    {
        return $this->procedure[count($this->procedure) - 1] ?? [];
    }

    /**
     * 加载镜像
     * @return array
     */
    public function loadImage(): array
    {
        // 从redis或其他存储介质加载
        $this->chessboard = $this->fiveInFiveImage->getImage()['chessboard'] ?? [];
        if ($this->chessboard) {
            return $this->chessboard;
        }

        // 没加载到镜像 - 初始化棋盘
        $this->initChessboard();

        return $this->chessboard;
    }

    /**
     * 落子
     * @param int $color
     * @param int $x
     * @param int $y
     * @return void
     * @throws \Exception
     */
    public function skill(int $color, int $x, int $y)
    {
        // 棋盘为空
        if (empty($this->chessboard)) {
            $this->initChessboard();
        }

        // 判断是否越界
        if ($x < 0 || $x >= 15 || $y < 0 || $y >= 15) {
            throw new \Exception('越界');
        }

        // 判断是否为当前color操作
        if (!empty($this->procedure) && $this->procedure[count($this->procedure) - 1][0] == $color) {
            throw new \Exception('未轮到你');
        }

        // 判断是否已有棋子
        if ($this->chessboard[$x][$y] != 0) {
            throw new \Exception('此处已有棋子');
        }

        // 落子
        $this->chessboard[$x][$y] = $color;

        // 记录步骤
        $this->procedure[] = [$color, $x, $y];

        // 保存镜像
        $this->fiveInFiveImage->setImage($this->chessboard, $this->procedure);

        // 判断输赢
        $judge = $this->judge($color, $x, $y);
        if ($judge) {
            throw new \Exception("{$color}获胜");
        }
    }

    /**
     * 判断输赢
     * @param int $color
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function judge(int $color, int $x, int $y): bool
    {
        // 定义四个主要方向：水平、垂直、两个对角线
        $directions = [
            [[0, 1], [0, -1]],   // 水平方向
            [[1, 0], [-1, 0]],   // 垂直方向
            [[1, 1], [-1, -1]],  // 主对角线
            [[1, -1], [-1, 1]]   // 副对角线
        ];

        foreach ($directions as $direction) {
            $count = 1; // 当前刚落下的棋子

            // 向两个相反方向检测
            foreach ($direction as $d) {
                $i = $x + $d[0];
                $j = $y + $d[1];

                // 在棋盘范围内持续检测
                while ($i >= 0 && $i < 15 && $j >= 0 && $j < 15) {
                    if ($this->chessboard[$i][$j] == $color) {
                        $count++;
                        // 沿当前方向继续前进
                        $i += $d[0];
                        $j += $d[1];
                    } else {
                        break;
                    }
                }
            }

            // 发现五连即获胜
            if ($count >= 5) {
                return true;
            }
        }

        return false;
    }
}
