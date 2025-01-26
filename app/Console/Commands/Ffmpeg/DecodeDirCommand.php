<?php

namespace App\Console\Commands\Ffmpeg;

use Illuminate\Console\Command;

class DecodeDirCommand extends Command
{
    protected $signature = 'ffmpeg:decode-dir';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '解析目录';

    private string $outPath;
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $inputPath = '/Volumes/Fanxiang2T/music/莫文蔚';
        $this->outPath = '/Volumes/Fanxiang2T/music/mp3_2';

        if (!is_dir($this->outPath)) {
            mkdir($this->outPath, 0777, true);
        }

        // 递归解析目录
        $this->decodeDir($inputPath);

        $this->info('done...');
    }

    private function decodeDir(string $dir)
    {
        // dir最后一层的文件夹名
        $dirArr  = explode('/', $dir);
        $dirLast = end($dirArr);

        $items = scandir($dir);

        foreach ($items as $item) {

            // 如果第一个字符是.
            if ($item[0] == '.') {
                continue;
            }

            $path = $dir . '/' . $item;

            if (is_dir($path)) {
                $this->decodeDir($path);

                continue;
            }

            if (is_file($path)) {

                $info = pathinfo($item);
                $filename = $info['filename']; // 文件名，不带后缀
                $extension = strtolower($info['extension']); // flac

                $inputPath = $dir . '/' . $item;
                $outPath = $this->outPath . '/' . $dirLast . '_' . $filename . '.mp3';

                // 直接搬运
                if ($extension == 'mp3') {

                    if (file_exists($outPath)) {
                        $this->info('exists skip .....' . $outPath);
                        continue;
                    }

                    $cmd = sprintf('mv "%s" "%s"', $inputPath, $outPath);
                    exec($cmd);
                    continue;
                }

                if (!in_array($extension, ['flac', 'ape'])) { // TODO
                    continue;
                }

                if (file_exists($outPath)) {
                    $this->info('exists skip .....' . $outPath);
                    continue;
                }

                $cmd = sprintf('ffmpeg -i "%s" -ab 192k "%s"', $inputPath, $outPath);

                exec($cmd);
            }
        }
    }

}
