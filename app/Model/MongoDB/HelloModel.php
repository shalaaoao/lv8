<?php

namespace App\Model\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;

class HelloModel extends Model
{
    protected $connection = 'mongodb';
    protected $collection= 'hello';

}
