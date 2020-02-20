<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageListCheckCommand;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageListCommand;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageSettingCommand;

/**
 * Class CommandServiceProvider
 * @package Shibuyakosuke\LaravelCrudGenerator\Providers
 */
class CommandServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->registerCommands();

        $lang = App::getLocale();

        if (Str::is($lang, 'en')) {
            return;
        }

        $this->publishes([
            sprintf('%s/%s/%s', __DIR__, '../Resources/lang', $lang) =>
                resource_path(sprintf('lang/%s', $lang)),
            sprintf('%s/%s/%s.json', __DIR__, '../Resources/lang', $lang) =>
                resource_path(sprintf('lang/%s.json', $lang)),
        ]);
    }

    public function register()
    {
        // register bindings
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.shibuyakosuke.lang.setting', function () {
            return new LanguageSettingCommand();
        });
        $this->app->singleton('command.shibuyakosuke.lang.list', function () {
            return new LanguageListCommand();
        });
        $this->app->singleton('command.shibuyakosuke.lang.check', function () {
            return new LanguageListCheckCommand();
        });

        $this->commands([
            'command.shibuyakosuke.lang.setting',
            'command.shibuyakosuke.lang.list',
            'command.shibuyakosuke.lang.check',
        ]);
    }

    public function provides()
    {
        return [
            'command.shibuyakosuke.lang.setting',
            'command.shibuyakosuke.lang.list',
        ];
    }
}
