<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use ShibuyaKosuke\LaravelLanguageSetting\Providers\CommandServiceProvider;

class LanguageSettingCommand extends Command
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

        if (App::getLocale() === $language) {
            $this->call('vendor:publish', [
                '--provider' => CommandServiceProvider::class
            ]);
            return;
        }

        $this->error(sprintf(
            'Error: Set locale \'%s\' to \'%s\' in config/app.php',
            App::getLocale(),
            $this->argument('language')
        ));
    }
}