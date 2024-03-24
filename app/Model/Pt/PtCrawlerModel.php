<?php

namespace App\Model\Pt;

use App\Model\BaseModel;

class PtCrawlerModel extends BaseModel
{
    protected $connection = 'mysql';

    protected $table = 'pt_crawler';

    public    $timestamps = true;
    protected $fillable   = [
        'mode',
        'keyword',
        'discount',
        'rule',
        'frequency',
        'status',
    ];

    const MODE_ADULT   = 'adult';
    const MODE_TVSHOW  = 'tvshow';

    const STATUS_ING    = 0;
    const STATUS_DONE   = 1;
    const STATUS_STOP   = 2;

    const DISCOUNT_FREE = 'FREE';
    const DISCOUNT_NULL = '';

    public function getRuleArrAttribute(): array
    {
        return json_decode($this->rule, true) ?? [];
    }
}
