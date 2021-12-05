<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

/**
 * Interface GeneratorServiceInterface
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
interface GeneratorServiceInterface
{
    /**
     * @type string
     */
    public const FIELD_NAME_ID = 'id';
    /**
     * @type string
     */
    public const FIELD_NAME_DELETED_AT = 'deleted_at';
    /**
     * @type string
     */
    public const FIELD_NAME_CREATED_AT = 'created_at';
    /**
     * @type string
     */
    public const FIELD_NAME_UPDATED_AT = 'updated_at';
    /**
     * @type string
     */
    public const FIELD_TYPE_INTEGER = 'integer';
    /**
     * @type string
     */
    public const FIELD_TYPE_INT = 'int';
    /**
     * @type string
     */
    public const FIELD_TYPE_CARBON = 'Carbon';
    /**
     * @type string
     */
    public const FIELD_TYPE_STRING = 'string';
    /**
     * @type string
     */
    public const CUSTOM_FILE_TEMPLATE_KEY = 'template';
    /**
     * @type string
     */
    public const CUSTOM_FILE_OUTPUT_FILE_KEY = 'outputFile';
    /**
     * @type string
     */
    public const CUSTOM_FILE_MODE_KEY = 'mode';
    /**
     * @type string
     */
    public const CUSTOM_FILE_FORMAT_KEY = 'format';
    /**
     * @type string
     */
    public const MODE_MODIFICATION = 'modification';
    /**
     * @type string
     */
    public const MODE_SYSTEM = 'system';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_ENTITY = 'entity';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_MIGRATION = 'migration';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_SEEDER = 'seeder';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_RESPONSE = 'response';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER = 'controller';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER_LIST = 'controllerList';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER_BY_ID = 'controllerById';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER_CREATE = 'controllerCreate';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER_UPDATE = 'controllerUpdate';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_CONTROLLER_DELETE = 'controllerDelete';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_ROUTE = 'route';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_TEST = 'test';
    /**
     * @type string
     */
    public const CUSTOM_FILE_CONTEXT_API_DOC = 'apiDoc';
    /**
     * @type string
     */
    public const FILESYSTEM_DISK = 'generator';
    /**
     * @type string
     */
    public const RELATION_MANY_TO_MANY = 'belongsToMany';
    /**
     * @type string
     */
    public const SETS_DEFAULT_VALUE = 'default';

    /**
     * @param array $data
     * @param bool $formatted
     * @return array
     */
    public function generateFileList(array $data, $formatted = false): array;

    /**
     * @param array $data
     */
    public function generateFiles(array $data): void;

    /**
     * @return array
     */
    public function setsList(): array;
}
