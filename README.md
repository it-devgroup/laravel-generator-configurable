## 

## Description

- separate generation of each section related to the entity (entity, controller, resources, etc.)

- splitting generation into contexts (api, dashboard, etc.)
  
- customizable templates for different contexts (blade templates)
  
- selective generation of each of the files
  
- test mode

## Install for Lumen

**1.** Open file `bootstrap/app.php` and add new service provider
```
$app->register(\ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider::class);
```
Uncommented string
```
$app->withFacades();
```
Added after **$app->configure('app');**
```
$app->configure('generator');
```
If not then add
```
$app->configure('filesystems');
```

**2.** Run commands

For creating config file
```
php artisan generator:publish --tag=config
```
For generate default blade templates
```
php artisan generator:publish --tag=resources
```

## Install for laravel

**1.** Open file **config/app.php** and search
```
    'providers' => [
        ...
    ]
```
Add to section
```
        \ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider::class,
```
Example
```
    'providers' => [
        ...
        \ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider::class,
    ]
```

**2.** Run commands

For creating config file
```
php artisan vendor:publish --provider="ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider" --tag=config
```
For generate default blade templates
```
php artisan vendor:publish --provider="ItDevgroup\LaravelGeneratorConfigurable\Providers\GeneratorServiceProvider" --tag=resources
```

## Continue step install for laravel or lumen

**1.** Add folder `storage/generator` to .gitignore at the root of the project

**2.** Edit templates `resources/views/vendor/laravel-generator-configurable/templates`
and config file `config/generator.php`

## ENV variables

File .env

Enable generator (1 - enable (only development), empty - disable)
```
GENERATOR_ENABLE=1
```
Enable test mode for generator (1 - test mode for debug, empty - live mode)
```
GENERATOR_TEST_MODE=1
```
## Run generator
Open url in browser ({{YOUR_URL}} - replace to your domain)
```
http://{{YOUR_URL}}/generator
```
## Documentation
The documentation is located (inside the component folder) in the folder `/vendor/it-devgroup/laravel-generator-configurable/docs`
