<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageListCheckCommand;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageListCommand;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageMockCommand;
use ShibuyaKosuke\LaravelLanguageSetting\Console\LanguageSettingCommand;

/**
 * Class CommandServiceProvider
 * @package Shibuyakosuke\LaravelCrudGenerator\Providers
 */
class CommandServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected function langPath(string $lang): string
    {
      if ((int) explode('.', app()->version())[0] >= 9) {
        return app()->langPath($lang);
      }

      return resource_path(sprintf('lang/%s', $lang));
    }

    public function boot()
    {
        $this->registerCommands();

        $lang = App::getLocale();

        if (Str::is($lang, 'en')) {
            return;
        }

        $this->publishes([
            sprintf('%s/%s/%s', __DIR__, '../Resources/lang', $lang) =>
                $this->langPath($lang),
            sprintf('%s/%s/%s.json', __DIR__, '../Resources/lang', $lang) =>
                $this->langPath(sprintf('%s.json', $lang)),
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
        $this->app->singleton('command.shibuyakosuke.lang.mock', function () {
            return new LanguageMockCommand();
        });

        $this->commands([
            'command.shibuyakosuke.lang.setting',
            'command.shibuyakosuke.lang.list',
            'command.shibuyakosuke.lang.check',
            'command.shibuyakosuke.lang.mock',
        ]);
    }

    public function provides()
    {
        return [
            'command.shibuyakosuke.lang.setting',
            'command.shibuyakosuke.lang.list',
            'command.shibuyakosuke.lang.check',
            'command.shibuyakosuke.lang.mock',
        ];
    }
}
