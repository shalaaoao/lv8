<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Mediator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:mediator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-中介者模式';

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
        $m = new ChatMediator();

        $u1 = new ChatUser($m, 1);
        $u2 = new ChatUser($m, 2);
        $u3 = new ChatUser($m, 3);

        $m->attach($u1);
        $m->attach($u2);
        $m->attach($u3);

        $u1->send("Hello Everyone~"); // 用户2、3收到消息
        $u2->send("What's up!"); // 用户1、3收到消息

        $m->detach($u2); // 用户2退出聊天室

        $u3->send("I'm fine"); // 用户1收到消息
    }
}

abstract class AMediator
{
    abstract public function send(string $message, User $sendUser);
}

class ChatMediator extends AMediator
{
    public array $users = [];

    public function attach(User $user)
    {
        if (!in_array($user, $this->users)) {
            $this->users[] = $user;
        }
    }

    public function detach(User $user)
    {
        foreach ($this->users as $k => $vUser) {
            if ($user == $vUser) {
                array_splice($this->users, $k, 1);
            }
        }
    }

    public function send(string $message, User $sendUser)
    {
        foreach ($this->users as $user) {
            if ($user == $sendUser) {
                continue;
            }

            $user->notify($message);
        }
    }
}

abstract class User
{
    protected AMediator $mediator;
    protected int       $userId;

    public function __construct(AMediator $mediator, int $userId)
    {
        $this->mediator = $mediator;
        $this->userId   = $userId;
    }
}

class ChatUser extends User
{
    public function send(string $message)
    {
        $this->mediator->send($message . "(userId:{$this->userId}发送)", $this);
    }

    public function notify(string $message)
    {
        echo "userId:" . $this->userId . '收到消息：' . $message, PHP_EOL;
    }
}
