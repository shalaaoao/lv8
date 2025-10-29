<?php

namespace App\Entity\Game;

use Illuminate\Support\Facades\Redis;

class FiveInFiveImage
{
    private string $gameUuid;

    const IMAGE_KEY = 'five_in_five_image';


    public function __construct(string $gameUuid)
    {
        $this->gameUuid = $gameUuid;
    }

    /**
     * 获取镜像
     * @return array
     */
    public function getImage(): array
    {
        $data = Redis::get(self::IMAGE_KEY . ':' . $this->gameUuid);
        if (!$data) {
            return [];
        }

        $dataArr = json_decode($data, true);

        // structure

        return $this->structure($dataArr);
    }

    /**
     * 结构化
     * @param array $data
     * @return array
     */
    private function structure(array $data): array
    {
        $chessboard = $data['chessboard'] ?? [];
        $procedure  = $data['procedure'] ?? [];

        return [
            'chessboard' => $chessboard,
            'procedure'  => $procedure,
        ];
    }

    /**
     * 设置镜像
     * @param array $chessboard
     * @param array $procedure
     */
    public function setImage(array $chessboard, array $procedure): void
    {
        $data = [
            'chessboard' => $chessboard,
            'procedure'  => $procedure,
        ];

        Redis::set(self::IMAGE_KEY . ':' . $this->gameUuid, json_encode($data));
        Redis::expire(self::IMAGE_KEY . ':' . $this->gameUuid, 7200);
    }
}
