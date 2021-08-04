<?php

use ItDevgroup\LaravelGeneratorConfigurable\GeneratorServiceInterface;

return [
    'enable' => env('GENERATOR_ENABLE', false),
    'templates' => resource_path('views/vendor/laravel-generator-configurable/templates/'),
    'testMode' => env('GENERATOR_TEST_MODE', true),
    'testFolder' => storage_path('generator/'),
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
