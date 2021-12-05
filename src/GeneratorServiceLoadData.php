<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataConfig;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerById;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerCreate;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerCreateField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerDelete;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerList;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerUpdate;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerUpdateField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataApiDoc;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntity;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityRelation;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilter;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilterField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataMigration;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataMigrationField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataResponse;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataResponseField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataRoute;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataSeeder;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataSeederField;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataTest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class GeneratorServiceLoadData
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceLoadData
{
    /**
     * @type string
     */
    private const FILTER_TYPE_RANGE = 'range';

    /**
     * @var Collection
     */
    private Collection $typeAliases;
    /**
     * @var Collection
     */
    private Collection $textFormatTypeAliases;

    /**
     * GeneratorServiceLoadData constructor.
     */
    public function __construct()
    {
        $this->typeAliases = collect(Config::get('generator.fieldTypeAliases'));
        $this->textFormatTypeAliases = collect(Config::get('generator.fieldTextFormatAliases'));
    }

    /**
     * @param array $data
     * @return GeneratorServiceData
     */
    public function loadData(array $data): GeneratorServiceData
    {
        $data = collect($data);

        return GeneratorServiceData::register(
            $this->loadDataEntity(collect($data->get('entity'))),
            $this->loadDataFilter(collect($data->get('filter'))),
            $this->loadDataMigration(collect($data->get('migration'))),
            $this->loadDataSeeder(collect($data->get('seeder'))),
            $this->loadDataResponse(collect($data->get('response'))),
            $this->loadDataControllerCreate(collect($data->get('controller'))),
            $this->loadDataControllerUpdate(collect($data->get('controller'))),
            $this->loadDataControllerList(collect($data->get('controller'))),
            $this->loadDataControllerById(collect($data->get('controller'))),
            $this->loadDataControllerDelete(collect($data->get('controller'))),
            $this->loadDataRoute(collect($data->get('route'))),
            $this->loadDataTest(collect($data->get('test'))),
            $this->loadDataApiDoc(collect($data->get('apiDoc'))),
            $this->loadDataConfig(collect($data->get('config')))
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataEntity
     */
    private function loadDataEntity(Collection $data): GeneratorServiceDataEntity
    {
        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataEntityField::register(
                    $field->get('field'),
                    $field->get('type'),
                    $this->getTextFormatTypeByAlias($field->get('type')),
                    $this->getTypeByAlias($field->get('type')),
                    (bool)$field->get('multiLanguage'),
                    (bool)$field->get('nullable'),
                    (bool)$field->get('sortable')
                );
            }
        }

        $relations = [];
        if (is_array($data->get('relations'))) {
            foreach ($data->get('relations') as $relation) {
                $relation = collect($relation);
                $relations[] = GeneratorServiceDataEntityRelation::register(
                    $relation->get('field'),
                    $relation->get('type'),
                    $relation->get('entity'),
                    $relation->get('table'),
                    $relation->get('foreign'),
                    $relation->get('local')
                );
            }
        }

        return GeneratorServiceDataEntity::register(
            $data->get('name'),
            $data->get('table'),
            $data->get('deletedAt'),
            $data->get('createdAt'),
            $data->get('updatedAt'),
            $fields,
            $relations
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataFilter
     */
    private function loadDataFilter(Collection $data): GeneratorServiceDataFilter
    {
        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                if ($field->get('operator') == self::FILTER_TYPE_RANGE) {
                    $fields[] = GeneratorServiceDataFilterField::register(
                        $field->get('name') . 'From',
                        $field->get('type'),
                        $this->getTextFormatTypeByAlias($field->get('type')),
                        $this->getTypeByAlias($field->get('type')),
                        '>=',
                        $field->get('field')
                    );
                    $fields[] = GeneratorServiceDataFilterField::register(
                        $field->get('name') . 'To',
                        $field->get('type'),
                        $this->getTextFormatTypeByAlias($field->get('type')),
                        $this->getTypeByAlias($field->get('type')),
                        '<=',
                        $field->get('field')
                    );
                } else {
                    $fields[] = GeneratorServiceDataFilterField::register(
                        $field->get('name'),
                        $field->get('type'),
                        $this->getTextFormatTypeByAlias($field->get('type')),
                        $this->getTypeByAlias($field->get('type')),
                        $field->get('operator'),
                        $field->get('field')
                    );
                }
            }
        }

        return GeneratorServiceDataFilter::register(
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataMigration
     */
    private function loadDataMigration(Collection $data): GeneratorServiceDataMigration
    {
        if (!$data->get('enable')) {
            $data = collect();
        }

        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataMigrationField::register(
                    $field->get('field'),
                    $field->get('type'),
                    $field->get('value'),
                    $field->get('param1'),
                    $field->get('param2'),
                    (bool)$field->get('nullable'),
                    (bool)$field->get('index')
                );
            }
        }

        return GeneratorServiceDataMigration::register(
            (bool)$data->get('enable'),
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataSeeder
     */
    private function loadDataSeeder(Collection $data): GeneratorServiceDataSeeder
    {
        if (!$data->get('enable')) {
            $data = collect();
        }

        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataSeederField::register(
                    $field->get('field')
                );
            }
        }

        return GeneratorServiceDataSeeder::register(
            (bool)$data->get('enable'),
            (int)$data->get('countRows'),
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataResponse
     */
    private function loadDataResponse(Collection $data): GeneratorServiceDataResponse
    {
        if (!$data->get('enable')) {
            $data = collect();
        }

        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataResponseField::register(
                    $field->get('variable'),
                    $field->get('field'),
                    (bool)$field->get('multiLanguage')
                );
            }
        }

        return GeneratorServiceDataResponse::register(
            (bool)$data->get('enable'),
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataControllerCreate
     */
    private function loadDataControllerCreate(Collection $data): GeneratorServiceDataControllerCreate
    {
        $data = collect($data->get('create'));

        if (!$data->get('enable')) {
            $data = collect();
        }

        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataControllerCreateField::register(
                    $field->get('variable'),
                    $field->get('type'),
                    $this->getTextFormatTypeByAlias($field->get('type')),
                    $this->getTypeByAlias($field->get('type')),
                    $field->get('field'),
                    (bool)$field->get('required'),
                    (bool)$field->get('nullable'),
                    (bool)$field->get('multiLanguage'),
                    (bool)$field->get('entityEnable'),
                    $field->get('entity')
                );
            }
        }

        return GeneratorServiceDataControllerCreate::register(
            (bool)$data->get('enable'),
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataControllerUpdate
     */
    private function loadDataControllerUpdate(Collection $data): GeneratorServiceDataControllerUpdate
    {
        $data = collect($data->get('update'));

        if (!$data->get('enable')) {
            $data = collect();
        }

        $fields = [];
        if (is_array($data->get('fields'))) {
            foreach ($data->get('fields') as $field) {
                $field = collect($field);
                $fields[] = GeneratorServiceDataControllerUpdateField::register(
                    $field->get('variable'),
                    $field->get('type'),
                    $this->getTextFormatTypeByAlias($field->get('type')),
                    $this->getTypeByAlias($field->get('type')),
                    $field->get('field'),
                    (bool)$field->get('required'),
                    (bool)$field->get('nullable'),
                    (bool)$field->get('multiLanguage'),
                    (bool)$field->get('entityEnable'),
                    $field->get('entity')
                );
            }
        }

        return GeneratorServiceDataControllerUpdate::register(
            (bool)$data->get('enable'),
            $fields
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataControllerById
     */
    private function loadDataControllerById(Collection $data): GeneratorServiceDataControllerById
    {
        $data = collect($data->get('byId'));

        return GeneratorServiceDataControllerById::register(
            (bool)$data->get('enable')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataControllerList
     */
    private function loadDataControllerList(Collection $data): GeneratorServiceDataControllerList
    {
        $data = collect($data->get('list'));

        return GeneratorServiceDataControllerList::register(
            (bool)$data->get('enable')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataControllerDelete
     */
    private function loadDataControllerDelete(Collection $data): GeneratorServiceDataControllerDelete
    {
        $data = collect($data->get('delete'));

        return GeneratorServiceDataControllerDelete::register(
            (bool)$data->get('enable')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataRoute
     */
    private function loadDataRoute(Collection $data): GeneratorServiceDataRoute
    {
        return GeneratorServiceDataRoute::register(
            (bool)$data->get('enable'),
            $data->get('filename'),
            $data->get('prefix')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataTest
     */
    private function loadDataTest(Collection $data): GeneratorServiceDataTest
    {
        return GeneratorServiceDataTest::register(
            (bool)$data->get('enable')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataApiDoc
     */
    private function loadDataApiDoc(Collection $data): GeneratorServiceDataApiDoc
    {
        return GeneratorServiceDataApiDoc::register(
            (bool)$data->get('enable')
        );
    }

    /**
     * @param Collection $data
     * @return GeneratorServiceDataConfig
     */
    private function loadDataConfig(Collection $data): GeneratorServiceDataConfig
    {
        return GeneratorServiceDataConfig::register(
            $data->get('contextController'),
            $data->get('contextTest'),
            $data->get('contextApiDoc'),
            $data->get('sets')
        );
    }

    /**
     * @param string|null $type
     * @return string|null
     */
    private function getTypeByAlias(?string $type): ?string
    {
        return $this->typeAliases->get($type) ? $this->typeAliases->get($type) : $type;
    }

    /**
     * @param string|null $type
     * @return string|null
     */
    private function getTextFormatTypeByAlias(?string $type): ?string
    {
        return $this->textFormatTypeAliases->get($type) ? $this->textFormatTypeAliases->get($type) : $type;
    }
}
