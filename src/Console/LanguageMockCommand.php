<?php

namespace ShibuyaKosuke\LaravelLanguageSetting\Console;

class LanguageMockCommand extends Language
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:mock  {language : language name like \'ja\'}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate mock files.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $language = $this->argument('language');
        $target = (str_replace('Console', 'Resources', __DIR__));

        $this->getFilenames('en')->each(function ($file) use ($target, $language) {
            $dest = str_replace($target, '', $file);
            $dest = str_replace('/lang/en', 'lang/' . $language, $dest);
            $dest = resource_path($dest);
            if (!file_exists(dirname($dest))) {
                mkdir(dirname($dest), 0777, true);
            }
            copy($file, $dest);
        });
        $this->info(sprintf('Success: output %s files.', $language));
    }
}