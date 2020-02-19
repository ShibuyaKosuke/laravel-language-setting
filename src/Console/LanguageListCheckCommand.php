<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Finder\SplFileInfo;
use function Composer\Autoload\includeFile;

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
            'json' => sprintf('%s%s%s.json', __DIR__, '/../Resources/lang/', $language),
            'auth' => sprintf('%s%s%s/auth.php', __DIR__, '/../Resources/lang/', $language),
            'pagination' => sprintf('%s%s%s/pagination.php', __DIR__, '/../Resources/lang/', $language),
            'passwords' => sprintf('%s%s%s/passwords.php', __DIR__, '/../Resources/lang/', $language),
            'validation' => sprintf('%s%s%s/validation.php', __DIR__, '/../Resources/lang/', $language),
        ]);
    }

    private function getKeys($language)
    {
        $files = $this->getFilenames($language);
        $files->map(function ($file, $key) {
            if ($key === 'json') {
                $keys = array_keys(json_decode(file_get_contents($file), true, 512, JSON_OBJECT_AS_ARRAY));
            } else {
            }
        });
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
        $this->getKeys($language);
    }
}
