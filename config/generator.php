<?php

use ItDevgroup\LaravelGeneratorConfigurable\GeneratorServiceInterface;

return [
    /*
    |--------------------------------------------------------------------------
    | Enable generator
    |--------------------------------------------------------------------------
    | Enable urls of generator and processing of generation
    */
    'enable' => env('GENERATOR_ENABLE', false),

    /*
    |--------------------------------------------------------------------------
    | Template folder
    |--------------------------------------------------------------------------
    | Blade templates folder for generator
    */
    'templates' => resource_path('views/vendor/laravel-generator-configurable/templates/'),

    /*
    |--------------------------------------------------------------------------
    | Enable test mode
    |--------------------------------------------------------------------------
    | Generate files in a special test folder, used to set up and test customized templates before running the generator for real entities
    */
    'testMode' => env('GENERATOR_TEST_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | A folder for generating test templates
    |--------------------------------------------------------------------------
    */
    'testFolder' => storage_path('generator/'),

    /*
    |--------------------------------------------------------------------------
    | Setting default templates for each generator section
    |--------------------------------------------------------------------------
    | Available generator sections:
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY - entity
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION - migration
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER - seeds
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE - response
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER - controller
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_LIST - controller: list
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_BY_ID - controller: by id
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_CREATE - controller: create
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_UPDATE - controller: update
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_DELETE - controller: delete
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_CREATE - controller: create
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST - tests
    |   GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC - api docs
    |
    | Example:
    |   'customFiles' => [
    |       GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY => [
    |           [
    |                'template' => 'entity.blade.php', // blade template
    |                'outputFile' => 'app/Domain/%/%.php', // path to the final file relative to the project root
    |                ... // extra params (if needed)
    |            ]
    |        ],
    |        ...
    |   ]
    | Extra params:
    |   'format' => 'text' // generate file as text
    |   'mode' => 'system' // the file is a system file and the only available action with it is to write the required text to the end of the file
    | Variables:
    |   % - entity name
    |   %migrationDate% - migration date
    |   %contextPath% - extra folder path for the generated template
    |   %context% - extra folder name for the generated template
    */
    'customFiles' => [
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY => [
            [
                'template' => 'entity.blade.php',
                'outputFile' => 'app/Domain/%/%.php',
            ],
            [
                'template' => 'entity_filter.blade.php',
                'outputFile' => 'app/Domain/%/%Filter.php',
            ],
            [
                'template' => 'entity_repository_interface.blade.php',
                'outputFile' => 'app/Domain/%/%RepositoryInterface.php',
            ],
            [
                'template' => 'entity_repository.blade.php',
                'outputFile' => 'app/Infrastructure/PostgresRepository/Eloquent%Repository.php',
            ],
            [
                'template' => 'repository_service_provider.blade.php',
                'outputFile' => 'app/Providers/RepositoryServiceProvider.php',
                'mode' => 'system',
                'format' => 'text',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION => [
            [
                'template' => 'migration.blade.php',
                'outputFile' => 'database/migrations/%migrationDate%_create_%.php',
            ],
            [
                'template' => 'migration_relationship.blade.php',
                'outputFile' => 'database/migrations/%migrationDate%_create_%.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER => [
            [
                'template' => 'seeder.blade.php',
                'outputFile' => 'database/seeds/%TableSeeder.php',
            ],
            [
                'template' => 'seeder_database.blade.php',
                'outputFile' => 'database/seeds/DatabaseSeeder.php',
                'mode' => 'system',
                'format' => 'text',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE => [
            [
                'template' => 'response_resource.blade.php',
                'outputFile' => 'app/Http/Resources/%/%Resource.php',
            ],
            [
                'template' => 'response_resource_collection.blade.php',
                'outputFile' => 'app/Http/Resources/%/%ResourceCollection.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER => [
            [
                'template' => 'controller.blade.php',
                'outputFile' => 'app/Http/Controllers/%contextPath%%Controller.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_LIST => [
            [
                'template' => 'controller_list_command.blade.php',
                'outputFile' => 'app/Application/%/Get%List.php',
            ],
            [
                'template' => 'controller_list_command_handler.blade.php',
                'outputFile' => 'app/Application/%/Get%ListHandler.php',
            ],
            [
                'template' => 'controller_list_request.blade.php',
                'outputFile' => 'app/Http/Requests/%/%RequestList.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_BY_ID => [
            [
                'template' => 'controller_by_id_command.blade.php',
                'outputFile' => 'app/Application/%/Get%ById.php',
            ],
            [
                'template' => 'controller_by_id_command_handler.blade.php',
                'outputFile' => 'app/Application/%/Get%ByIdHandler.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_CREATE => [
            [
                'template' => 'controller_create_command.blade.php',
                'outputFile' => 'app/Application/%/Register%.php',
            ],
            [
                'template' => 'controller_create_command_handler.blade.php',
                'outputFile' => 'app/Application/%/Register%Handler.php',
            ],
            [
                'template' => 'controller_create_request.blade.php',
                'outputFile' => 'app/Http/Requests/%/%RequestCreate.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_UPDATE => [
            [
                'template' => 'controller_update_command.blade.php',
                'outputFile' => 'app/Application/%/Update%.php',
            ],
            [
                'template' => 'controller_update_command_handler.blade.php',
                'outputFile' => 'app/Application/%/Update%Handler.php',
            ],
            [
                'template' => 'controller_update_request.blade.php',
                'outputFile' => 'app/Http/Requests/%/%RequestUpdate.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_DELETE => [
            [
                'template' => 'controller_delete_command.blade.php',
                'outputFile' => 'app/Application/%/Delete%.php',
            ],
            [
                'template' => 'controller_delete_command_handler.blade.php',
                'outputFile' => 'app/Application/%/Delete%Handler.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE => [
            [
                'template' => 'route.blade.php',
                'outputFile' => 'routes/%context%.php',
                'mode' => 'system',
                'format' => 'text',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST => [
            [
                'template' => 'test.blade.php',
                'outputFile' => 'tests/%contextPath%%context%%Test.php',
            ],
        ],
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC => [
            [
                'template' => 'api_doc.blade.php',
                'outputFile' => 'api-doc/%contextPath%%.js',
                'format' => 'text',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disable default set (for UI)
    |--------------------------------------------------------------------------
    | If you are using multiple contexts, the default context can be disabled for convenience.
    */
    'defaultCustomFilesDisable' => false,

    /*
    |--------------------------------------------------------------------------
    | Contexts
    |--------------------------------------------------------------------------
    | Contexts are intended to separate templates for different parts of the site, for example, you can configure different templates for api and dashboard contexts.
    | The template settings are the same as the default template set.
    |
    | Example:
    |   'sets' => [
    |       'api' => [
    |           'customFiles' => [
    |               GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY => [
    |                   [
    |                       'template' => 'sets_1/entity.blade.php',
    |                       'outputFile' => 'app/Domain/%/%.php',
    |                   ],
    |               ],
    |               ...
    |           ]
    |       ]
    |   ]
    */
    'sets' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom classes with variables
    |--------------------------------------------------------------------------
    | Custom classes with public methods (public methods are variables for templates) for each generator section
    */
    'variables' => [
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST => null,
        GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC => null,
    ],
    'fieldTypeAliases' => [
        'integer' => 'int',
        'boolean' => 'bool',
    ],
    'fieldTextFormatAliases' => [
        'Carbon' => 'string',
    ]
];
