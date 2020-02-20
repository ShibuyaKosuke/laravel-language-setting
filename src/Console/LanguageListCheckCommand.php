<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

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
     * @param $language
     * @return \Illuminate\Support\Collection
     */
    private function getFilenames($language)
    {
        return collect([
            'json' => realpath(sprintf('%s%s%s.json', __DIR__, '/../Resources/lang/', $language)),
            'auth' => realpath(sprintf('%s%s%s/auth.php', __DIR__, '/../Resources/lang/', $language)),
            'pagination' => realpath(sprintf('%s%s%s/pagination.php', __DIR__, '/../Resources/lang/', $language)),
            'passwords' => realpath(sprintf('%s%s%s/passwords.php', __DIR__, '/../Resources/lang/', $language)),
            'validation' => realpath(sprintf('%s%s%s/validation.php', __DIR__, '/../Resources/lang/', $language)),
        ]);
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $language = $this->argument('language');

        // file exist
        $files = $this->getFilenames($language);

        $res = $files->map(function ($file, $type) {
            return file_exists($file) ? 'OK' : 'NG';
        });

        $this->table($res->keys()->toArray(), [$res->values()->toArray()]);

        if ($res->contains('NG')) {
            $this->error('Error: lack of files needed.');
            return;
        }
    }
}
