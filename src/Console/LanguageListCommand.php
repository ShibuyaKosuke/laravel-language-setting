<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class LanguageListCommand extends Language
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show language list.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $rows = [];
        $files = File::allFiles(realpath(__DIR__ . '/../Resources/lang'));
        $collection = collect($files);

        $collection->map(function (SplFileInfo $file) use (&$rows) {
            $pathname = $file->getRelativePathname();
            $res = preg_match('/(.+)\.json|(.+)\/(.+)\.php/', $pathname, $matches);
            if ($res !== false) {
                if (count($matches) === 2) {
                    $lang = end($matches);
                    $rows[$lang]['lang'] = $lang;
                    $rows[$lang]['json'] = 'OK';
                } elseif (count($matches) === 4) {
                    $lang = $matches[2];
                    $rows[$lang]['lang'] = $lang;
                    $rows[$lang][$matches[3]] = 'OK';
                }
            }
        });

        $tmp = [];
        foreach ($rows as $lang => $item) {
            if (Str::is($lang, 'en')) {
                continue;
            }
            $tmp[] = array_merge([
                'lang' => null,
                'json' => null,
                'auth' => null,
                'pagination' => null,
                'passwords' => null,
                'validation' => null
            ], $item);
        }

        $header = ['language', 'json', 'auth', 'pagination', 'passwords', 'validation'];
        $this->table($header, $tmp);
    }
}