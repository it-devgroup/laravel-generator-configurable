<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Providers;

use ItDevgroup\LaravelGeneratorConfigurable\Console\Commands\GeneratorCommand;
use ItDevgroup\LaravelGeneratorConfigurable\GeneratorService;
use ItDevgroup\LaravelGeneratorConfigurable\GeneratorServiceInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class GeneratorServiceProvider
 * @package ItDevgroup\LaravelGeneratorConfigurable\Providers
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadCustomCommands();
        $this->loadCustomConfig();
        $this->loadCustomPublished();

        if (!Config::get('generator.enable')) {
            return;
        }

        $this->loadCustomView();
        $this->loadCustomClasses();
        $this->loadCustomRoutes();
        $this->loadCustomDisk();
    }

    /**
     * @return void
     */
    private function loadCustomCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                GeneratorCommand::class
            );
        }
    }

    /**
     * @return void
     */
    private function loadCustomConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/generator.php', 'generator');
    }

    /**
     * @return void
     */
    private function loadCustomPublished()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../../config' => base_path('config')
                ],
                'config'
            );
            $this->publishes(
                [
                    __DIR__ . '/../../resources/views/templates' => Config::get('generator.templates')
                ],
                'resources'
            );
        }
    }

    /**
     * @return void
     */
    private function loadCustomView()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/page', 'generator');

        View::composer(
            'generator::page',
            function (\Illuminate\Contracts\View\View $view) {
                $view->with(
                    'js',
                    [
                        __DIR__ . '/../../assets/js/chunk-vendors.js',
                        __DIR__ . '/../../assets/js/app.js',
                    ]
                );
                $view->with(
                    'css',
                    [
                        __DIR__ . '/../../assets/css/main.css',
                        __DIR__ . '/../../assets/css/bootstrap.min.css',
                        __DIR__ . '/../../assets/css/app.css',
                        __DIR__ . '/../../assets/css/chunk-vendors.css',
                    ]
                );
            }
        );
    }

    /**
     * @return void
     */
    private function loadCustomClasses()
    {
        $this->app->singleton(GeneratorServiceInterface::class, GeneratorService::class);
    }

    /**
     * @return void
     */
    private function loadCustomRoutes()
    {
        $option = [
            'prefix' => 'generator',
            'namespace' => 'ItDevgroup\LaravelGeneratorConfigurable\Http\Controllers',
        ];

        $controllerPrefix = get_class($this->app) == 'Laravel\Lumen\Application'
            ? 'Lumen' : 'Laravel';

        $this->app->router->group(
            $option,
            function ($router) use ($controllerPrefix) {
                $router->get(
                    '/',
                    [
                        'uses' => $controllerPrefix . 'GeneratorController@page',
                        'as' => 'generator.page',
                    ]
                );
                $router->post(
                    'check',
                    [
                        'uses' => $controllerPrefix . 'GeneratorController@check',
                        'as' => 'generator.check',
                    ]
                );
                $router->post(
                    'generate',
                    [
                        'uses' => $controllerPrefix . 'GeneratorController@generate',
                        'as' => 'generator.generate',
                    ]
                );
                $router->get(
                    'sets',
                    [
                        'uses' => $controllerPrefix . 'GeneratorController@sets',
                        'as' => 'generator.sets',
                    ]
                );
            }
        );
    }

    /**
     * @return void
     */
    private function loadCustomDisk()
    {
        $config = Config::get('filesystems.disks', []);
        $config[GeneratorServiceInterface::FILESYSTEM_DISK] = [
            'driver' => 'local',
            'root' => Config::get('generator.testMode') ? Config::get('generator.testFolder') : base_path(),
        ];
        Config::set('filesystems.disks', $config);
    }
}
