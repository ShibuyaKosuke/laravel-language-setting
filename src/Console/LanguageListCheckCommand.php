<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

class LanguageListCheckCommand extends Language
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
        $files = $this->getFilenames($language);

        $res = $files->map(function ($file, $type) {
            return ($file !== false && file_exists($file)) ? 'OK' : 'NG';
        });

        $this->table($res->keys()->toArray(), [$res->values()->toArray()]);

        if ($res->contains('NG')) {
            $this->error('Error: lack of files needed.');
            return;
        }
    }
}
