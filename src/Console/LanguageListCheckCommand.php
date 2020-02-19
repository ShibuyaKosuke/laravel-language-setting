<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class LanguageListCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:check {language : language name like \'ja\'}';

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
        $language = $this->argument('language');
        // file exist
        $files = collect([
            'json' => sprintf('%s.json', $language),
            'auth' => sprintf('%s/auth.php', $language),
            'pagination' => sprintf('%s/pagination.php', $language),
            'passwords' => sprintf('%s/passwords.php', $language),
            'validation' => sprintf('%s/validation.php', $language),
        ]);
        $res = $files->map(function ($file, $type) {
            return file_exists(__DIR__ . '/../Resources/lang/' . $file) ? 'OK' : 'NG';
        });
        $this->table($res->keys()->toArray(), [$res->values()->toArray()]);
    }
}