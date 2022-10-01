<?php

namespace App\Console\Commands\Oop;

use Illuminate\Console\Command;

class Magic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oop:magic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'oop魔术方法';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->abc('a', 'b');
//        self::abc('a', 1, ['cc']);

        $obj = new Obj('aaa');
//
//        dump('end new');
//        dump('end unset');
//
//        unset($a);

//        dump(isset($obj->prv));
    }

    public function __call($method, $parameters)
    {
        dump($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        dump($method, $parameters);
    }


}

class Obj
{
    private $prv;

    public function __construct($a = 'default prv')
    {
        $this->prv = $a;

//        dump("in construct");
    }

    public function __destruct()
    {
//        dump("in destruct");
    }

    public function __isset($name)
    {
        dump($name);
    }

    public function __invoke()
    {
        dump('in invoke...');
    }
}
