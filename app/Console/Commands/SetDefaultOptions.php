<?php

namespace App\Console\Commands;

use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class SetDefaultOptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed default CMS options from config file';

    /**
     * The options repository
     *
     * @var object
     */
    protected $options;

    /**
     * The languages repository
     */
    protected $language;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OptionRepositoryInterface $options, LanguageRepositoryInterface $language)
    {
        parent::__construct();

        $this->options = $options;
        $this->language = $language;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $defaultOptions = Config::get('cms.default_options');
        if (isset($defaultOptions) && !empty($defaultOptions)) {
            foreach ($defaultOptions as $defaultKey => $defaultValue) {
                $option = (object)[
                    'option_key' => $defaultKey,
                    'option_value' => $defaultValue
                ];
                try {
                    $this->insertForAllLanguages($option);
                } catch (RepositoryException $e) {
                    $this->error($e->getMessage());
                }
            }
        }
    }

    protected function insertForAllLanguages(\stdClass $option)
    {
        $languages = $this->language->all();
        foreach ($languages as $language) {
            $this->options->create([
                'key' => $option->option_key,
                'value' => $option->option_value,
                'type' => 'default',
                'locale' => $language->slug,
                'who_updated' => null
            ]);
        }
    }
}
