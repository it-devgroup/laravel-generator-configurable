<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Console\Commands;

use ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider;
use Illuminate\Console\Command;

/**
 * Class GeneratorCommand
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'generator:publish {--tag=* : Tag for published}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish files from generator';
    /**
     * @var array
     */
    private array $files = [];
    /**
     * @var array
     */
    private array $fileTags = [
        'config',
        'resources',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $option = $this->option('tag')[0];

        $this->parsePublishedFiles();

        switch ($option) {
            case 'config':
                $this->copyConfig();
                break;
            case 'resources':
                $this->copyResources();
                break;
        }
    }

    private function parsePublishedFiles()
    {
        $index = 0;
        foreach (GeneratorServiceProvider::pathsToPublish(GeneratorServiceProvider::class) as $k => $v) {
            $this->files[$this->fileTags[$index]] = [
                'from' => $k,
                'to' => $v,
            ];
            $index++;
        }
    }

    /**
     * @return void
     */
    private function copyConfig(): void
    {
        if (file_exists(base_path('config/generator.php'))) {
            $this->info('Config file skipped');
            return;
        }

        $this->copyFiles($this->files['config']['from'], $this->files['config']['to']);
    }

    /**
     * @return void
     */
    private function copyResources(): void
    {
        $this->copyFiles($this->files['resources']['from'], $this->files['resources']['to']);
    }

    /**
     * @param string $from
     * @param string $to
     */
    private function copyFiles(string $from, string $to): void
    {
        if (!file_exists($to)) {
            mkdir($to, 0755, true);
        }
        $from = rtrim($from, '/') . '/';
        $to = rtrim($to, '/') . '/';
        foreach (scandir($from) as $file) {
            if (!is_file($from . $file)) {
                continue;
            }

            $path = strtr(
                $to . $file,
                [
                    base_path() => ''
                ]
            );

            if (file_exists($to . $file)) {
                $this->info(
                    sprintf(
                        'File "%s" skipped',
                        $path
                    )
                );
                continue;
            }

            copy(
                $from . $file,
                $to . $file
            );

            $this->info(
                sprintf(
                    'File "%s" copied',
                    $path
                )
            );
        }
    }
}
