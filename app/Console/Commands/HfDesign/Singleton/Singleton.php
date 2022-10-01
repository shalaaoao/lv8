<?php

namespace App\Console\Commands\HfDesign\Singleton;

use Illuminate\Console\Command;

class Singleton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:singleton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 单例模式';

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
        C::getIns();
    }
}

class C
{
    private static C $ins;

    private function __construct() { }

    private function __clone() { }

    public static function getIns()
    {
        if (self::$ins instanceof C) {
            return self::$ins;
        }

        return self::$ins = new self();
    }
}
