<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Decorate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:decorate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-装饰器模式';

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
        $template = new CouponMessageTemplate();
        $message  = new DMessage();

        // 老系统，用不着过滤，只有内部用户能看到
        $message->send($template);

        // 新系统，面向全网发布，需要过滤一下内
        $message->msgType = 'new';
        $template = new AdFilterDecoratorMessage($template);
        $template = new SensitiveFilterDecoratorMessage($template);

        // 过滤完了，发送吧
        $message->send($template);
    }
}

// 短信模板接口
interface MessageTempate
{
    public function message(): string;
}

// 假设有很多模板实现了上面的短信模板接口
// 下面这个是其中一个优惠券发送的模板实现
class CouponMessageTemplate implements MessageTempate
{
    public function message(): string
    {
        return '优惠券信息：我们是全国第一的牛X产品哦，送您10张优惠券';
    }
}

// 我们来准备好装饰上面那个过时的短信模板
abstract class DecoratorMessageTemplate implements MessageTempate
{
    public $template;

    public function __construct($template)
    {
        $this->template = $template;
    }
}

// 过滤广告中法中不允许出现的词汇
class AdFilterDecoratorMessage extends DecoratorMessageTemplate
{
    public function message(): string
    {
        return str_replace('全国第一', '全国第二', $this->template->message());
    }
}

// 使用我们大数据部门同事，自动生成的新词库来过滤敏感词汇，这块过滤不是强制要过滤的内容，可选择使用
class SensitiveFilterDecoratorMessage extends DecoratorMessageTemplate
{
    public array $bigDataFilterWords  = ['牛X'];
    public array $bigDataReplaceWords = ['好用'];

    public function message(): string
    {
        return str_replace($this->bigDataFilterWords, $this->bigDataReplaceWords, $this->template->message());
    }
}

// 客户端，发送接口，需要使用模板来进行短信发送
class DMessage
{
    public string $msgType = 'old';

    public function send(MessageTempate $mt)
    {
        // 发送出去
        if ($this->msgType == 'old') {
            echo '面向内网用户发送' . $mt->message() . PHP_EOL;
        } elseif ($this->msgType == 'new') {
            echo '面向全网用户发送' . $mt->message() . PHP_EOL;
        }
    }
}
