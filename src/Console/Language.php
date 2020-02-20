<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Console\Command;

class Language extends Command
{

    /**
     * @param $language
     * @return \Illuminate\Support\Collection
     */
    protected function getFilenames($language)
    {
        return collect([
            'json' => realpath(sprintf('%s%s%s.json', __DIR__, '/../Resources/lang/', $language)),
            'auth' => realpath(sprintf('%s%s%s/auth.php', __DIR__, '/../Resources/lang/', $language)),
            'pagination' => realpath(sprintf('%s%s%s/pagination.php', __DIR__, '/../Resources/lang/', $language)),
            'passwords' => realpath(sprintf('%s%s%s/passwords.php', __DIR__, '/../Resources/lang/', $language)),
            'validation' => realpath(sprintf('%s%s%s/validation.php', __DIR__, '/../Resources/lang/', $language)),
        ]);
    }
}