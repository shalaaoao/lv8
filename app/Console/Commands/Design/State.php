<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class State extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-状态模式';

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
        $m = new Member();
        $m->SetState(new PlatinumMemeberState());

        $m->SetScore(1200);
        echo '当前会员' . $m->GetScore() . '积分，折扣为：' . $m->discount(), PHP_EOL;

        $m->SetScore(990);
        echo '当前会员' . $m->GetScore() . '积分，折扣为：' . $m->discount(), PHP_EOL;

        $m->SetScore(660);
        echo '当前会员' . $m->GetScore() . '积分，折扣为：' . $m->discount(), PHP_EOL;

        $m->SetScore(10);
        echo '当前会员' . $m->GetScore() . '积分，折扣为：' . $m->discount(), PHP_EOL;
    }
}

class Member
{
    private IState $state;
    private $score;

    public function SetState(IState $state)
    {
        $this->state = $state;
    }

    public function SetScore($score)
    {
        $this->score = $score;
    }

    public function GetScore()
    {
        return $this->score;
    }

    public function discount()
    {
        return $this->state->discount($this);
    }
}

interface IState
{
    public function discount($member);
}

class PlatinumMemeberState implements IState
{
    public function discount($member)
    {
        if ($member->GetScore() >= 1000) {
            return 0.80;
        } else {
            $member->SetState(new GoldMemberState());
            return $member->discount();
        }
    }
}

class GoldMemberState implements IState
{
    public function discount($member)
    {
        if ($member->GetScore() >= 800) {
            return 0.85;
        } else {
            $member->SetState(new SilverMemberState());
            return $member->discount();
        }
    }
}

class SilverMemberState implements IState
{
    public function discount($member)
    {
        if ($member->GetScore() >= 500) {
            return 0.90;
        } else {
            $member->SetState(new GeneralMemberState());
            return $member->discount();
        }
    }
}

class GeneralMemberState implements IState
{
    public function discount($member)
    {
        return 0.95;
    }
}
