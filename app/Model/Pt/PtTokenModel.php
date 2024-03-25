<?php

namespace App\Model\Pt;

use App\Model\BaseModel;

class PtTokenModel extends BaseModel
{
    protected $connection = 'mysql';

    protected $table = 'pt_token';

    public    $timestamps = true;
    protected $fillable   = [
        'web', 'token'
    ];

    public static function getToken(string $web): string
    {
        return (string)self::query()->where('web', $web)->value('token');
    }
}
