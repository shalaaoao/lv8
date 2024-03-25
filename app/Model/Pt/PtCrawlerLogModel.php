<?php

namespace App\Model\Pt;

use App\Model\BaseModel;

class PtCrawlerLogModel extends BaseModel
{
    protected $connection = 'mysql';

    protected $table = 'pt_crawler_logs';

    public    $timestamps = true;
    protected $fillable   = [
        'pt_crawler_id',
        'request',
        'match_result',
    ];
}
