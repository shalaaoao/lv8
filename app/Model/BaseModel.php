<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 所有model类的基类，override Eloquent model类的方法，适应分表及主从控制
 */
class BaseModel extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($limit = (int)request('limit')) {
            $this->setPerPage($limit);
        }
    }
}
