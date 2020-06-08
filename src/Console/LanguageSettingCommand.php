<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use ShibuyaKosuke\LaravelLanguageSetting\Providers\CommandServiceProvider;

class LanguageSettingCommand extends Language
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:setting {language : language name like \'ja\'}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish language files.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $language = $this->argument('language');

        $file_count = $this->getFilenames($language)
            ->filter(function ($filename) {
                return $filename !== false;
            })
            ->count();

        if ($file_count === 0) {
            $this->error(sprintf('Error: Language: \'%s\' is not available.', $language));
            return;
        }

        if (Str::is(App::getLocale(), $language)) {
            $this->call('vendor:publish', ['--provider' => CommandServiceProvider::class]);
            return;
        }

        $this->error(sprintf(
            'Error: Set locale \'%s\' to \'%s\' in config/App.php', App::getLocale(), $language
        ));
    }
}