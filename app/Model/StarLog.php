<?php

namespace App\Model;

class StarLog extends BaseModel
{
    protected $connection = 'mysql';

    protected $table = 'star_log';

    public    $timestamps = false;
    protected $fillable   = [
        'star_num',
        'star_type',
        'star_desc',
        'created_at',
    ];

    const STAR_TYPE_SPORT         = 1;
    const STAR_TYPE_NOT_MILK_TEAM = 2;
    const STAR_TYPE_NOT_HOTPOT    = 3;
    const STAR_TYPE_NOT_MEET      = 4;
    const STAR_TYPE_ANGRY         = 5;
    const STAR_TYPE_DEFINE        = 6;

    const STAR_TYPE_TEXT = [
        self::STAR_TYPE_SPORT         => '1天1运动',
        self::STAR_TYPE_NOT_MILK_TEAM => '3天不喝奶茶',
        self::STAR_TYPE_NOT_HOTPOT    => '7天不吃火锅',
        self::STAR_TYPE_NOT_MEET      => '陈总1天不来',
        self::STAR_TYPE_ANGRY         => '生气',
        self::STAR_TYPE_DEFINE        => '自定义',
    ];

    const STAR_TYPE_NUM = [
        self::STAR_TYPE_SPORT         => 1,
        self::STAR_TYPE_NOT_MILK_TEAM => 1,
        self::STAR_TYPE_NOT_HOTPOT    => 1,
        self::STAR_TYPE_NOT_MEET      => 2,
        self::STAR_TYPE_ANGRY         => -5,
        self::STAR_TYPE_DEFINE        => 0,
    ];

    public static function sumStar()
    {
        return (int)self::query()->sum('star_num');
    }

    // TODO 剩余可使用的
    public static function usableStar()
    {
        return (int)self::query()->sum('star_num');
    }

    public static function addData(int $star_num, int $star_type, string $star_desc, $created_at = '')
    {
        return self::query()->create([
            'star_num'   => $star_num,
            'star_type'  => $star_type,
            'star_desc'  => $star_desc,
            'created_at' => $created_at ?: date('Y-m-d H:i:s'),
        ]);
    }
}
