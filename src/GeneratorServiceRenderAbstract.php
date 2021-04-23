<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use Exception;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntity;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityRelation;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Class GeneratorServiceRenderAbstract
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
abstract class GeneratorServiceRenderAbstract
{
    /**
     * @var string
     */
    protected string $context = '';
    /**
     * @var string
     */
    protected string $folderTemplates;
    /**
     * @var Collection|null
     */
    private ?Collection $dataEntityFields = null;
    /**
     * @var Collection|null
     */
    private ?Collection $dataResponseFields = null;
    /**
     * @var Collection|null
     */
    private ?Collection $dataControllerCreateFields = null;
    /**
     * @var Collection|null
     */
    private ?Collection $dataControllerUpdateFields = null;
    /**
     * @var GeneratorServiceChunk
     */
    private GeneratorServiceChunk $generatorServiceChunk;

    /**
     * GeneratorServiceGenerate constructor.
     * @param GeneratorServiceChunk $generatorServiceChunk
     */
    public function __construct(
        GeneratorServiceChunk $generatorServiceChunk
    ) {
        $this->folderTemplates = $this->config('generator.templates');
        $this->generatorServiceChunk = $generatorServiceChunk;
    }

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    abstract public function renderFiles(GeneratorServiceData $data, Collection $files): void;

    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    protected function renderPHP(array $data, string $file): string
    {
        return sprintf(
            '%s%s%s',
            '<?php',
            PHP_EOL . PHP_EOL,
            view()->file($file, $data)->render()
        );
    }

    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    protected function renderText(array $data, string $file): string
    {
        return view()->file($file, $data)->render();
    }

    /**
     * @param array $data
     * @param GeneratorServiceDataFileRequest $file
     * @return string|null
     */
    protected function getContent(array $data, GeneratorServiceDataFileRequest $file): ?string
    {
        $filePath = sprintf(
            '%s%s',
            $this->folderTemplates,
            $file->getTemplate()
        );
        if (!file_exists($filePath)) {
            return null;
        }

        switch ($file->getFormat()) {
            case 'text':
                return $this->renderText($data, $filePath);
            default:
                return $this->renderPHP($data, $filePath);
        }
    }

    /**
     * @param Collection $collection
     * @param string|null $value
     */
    protected function addUniqueValueInCollection(Collection $collection, ?string $value): void
    {
        if (!$value) {
            return;
        }

        if ($collection->search($value) !== false) {
            return;
        }

        $collection->push($value);
    }

    /**
     * @param array $data
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function addExtraVariables(array &$data): void
    {
        $data['chunk'] = $this->generatorServiceChunk;

        $this->addExtraVariablesFromCustomClass($data);
    }

    /**
     * @param array $data
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function addExtraVariablesFromCustomClass(array &$data): void
    {
        $setting = 'generator.variables.' . $this->context;
        if (!$this->context || !$this->config($setting)) {
            return;
        }

        try {
            $class = new ReflectionClass($this->config($setting));
        } catch (Exception $e) {
            throw new Exception(
                sprintf(
                    'Generator: callback class "%s" not found in setting "%s"',
                    $this->config($setting),
                    $setting
                )
            );
        }

        $classObject = $class->newInstance();

        foreach ($class->getMethods() as $method) {
            if (!$method->isPublic()) {
                continue;
            }

            $key = sprintf(
                'custom%s',
                Str::ucfirst($method->getName())
            );
            $data[$key] = $method->invoke($classObject, $data);
        }
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function config(string $key, $default = null)
    {
        return Config::get($key, $default);
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @param bool $keyByField
     * @return Collection|GeneratorServiceDataEntityRelation[]
     */
    protected function getRelationFieldsFromEntity(
        GeneratorServiceDataEntity $entity,
        bool $keyByField = false
    ): Collection {
        $list = collect();

        foreach ($entity->getRelations() as $relation) {
            if ($keyByField) {
                $key = $relation->getLocal();
                if (
                    $relation->getType() == GeneratorServiceInterface::RELATION_MANY_TO_MANY
                    || $relation->getLocal() == 'id'
                ) {
                    continue;
                }
            } else {
                $key = $relation->getField();
            }
            $list->put($key, $relation);
        }

        return $list;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection
     */
    protected function getSortableFieldsFromEntity(
        GeneratorServiceData $data
    ): Collection {
        $list = collect();

        $list->push(GeneratorServiceInterface::FIELD_NAME_ID);

        foreach ($data->getEntity()->getFields() as $field) {
            if (!$field->isSortable()) {
                continue;
            }

            $list->push($field->getField());
        }

        if ($data->getEntity()->getDeletedAt()) {
            $list->push(GeneratorServiceInterface::FIELD_NAME_DELETED_AT);
        }

        if ($data->getEntity()->getCreatedAt()) {
            $list->push(GeneratorServiceInterface::FIELD_NAME_CREATED_AT);
        }

        if ($data->getEntity()->getUpdatedAt()) {
            $list->push(GeneratorServiceInterface::FIELD_NAME_UPDATED_AT);
        }

        return $list;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection|GeneratorServiceDataFieldData[]
     */
    protected function getFieldDataFromEntity(
        GeneratorServiceData $data
    ): Collection {
        if ($this->dataEntityFields) {
            return $this->dataEntityFields;
        }

        /** @var Collection|GeneratorServiceDataFieldData[] $list */
        $list = collect();

        foreach ($data->getEntity()->getFields() as $field) {
            $list->put(
                $field->getField(),
                GeneratorServiceDataFieldData::register(
                    $field->getField(),
                    null,
                    $field->getOriginType(),
                    $field->getTextFormatType(),
                    $field->getType(),
                    $field->isMultiLanguage(),
                    false,
                    null,
                    null,
                    false,
                    $field->isNullable(),
                    $field->isSortable()
                )
            );
        }

        foreach ($data->getEntity()->getRelations() as $field) {
            if (!$list->get($field->getField())) {
                $list->put(
                    $field->getField(),
                    GeneratorServiceDataFieldData::register(
                        $field->getField(),
                        null,
                        GeneratorServiceInterface::FIELD_TYPE_INTEGER,
                        GeneratorServiceInterface::FIELD_TYPE_INTEGER,
                        GeneratorServiceInterface::FIELD_TYPE_INT,
                        false,
                        true,
                        $field->getType(),
                        $field->getEntity(),
                        false,
                        true,
                        false
                    )
                );
            }
        }

        $this->dataEntityFields = $list;

        return $this->dataEntityFields;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection|GeneratorServiceDataFieldData[]
     */
    protected function getFieldsForControllerCreate(
        GeneratorServiceData $data
    ): Collection {
        if ($this->dataControllerCreateFields) {
            return $this->dataControllerCreateFields;
        }

        $list = $this->getFieldDataFromEntity($data);

        $this->dataControllerCreateFields = collect();
        foreach ($data->getControllerCreate()->getFields() as $field) {
            if ($list->get($field->getField())) {
                $list[$field->getField()]->setVariable($field->getVariable());
                $list[$field->getField()]->setOriginalType($field->getOriginalType());
                $list[$field->getField()]->setTextFormatType($field->getTextFormatType());
                $list[$field->getField()]->setType($field->getType());
                $list[$field->getField()]->setRelation($field->isEntityEnable());
                $list[$field->getField()]->setRelationEntity($field->getEntity());
                $list[$field->getField()]->setMultiLanguage($field->isMultiLanguage());
                $list[$field->getField()]->setRequired($field->isRequired());
                $list[$field->getField()]->setNullable($field->isNullable());
                $this->dataControllerCreateFields->push($list->get($field->getField()));
            }
        }

        return $this->dataControllerCreateFields;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection|GeneratorServiceDataFieldData[]
     */
    protected function getFieldsForControllerUpdate(
        GeneratorServiceData $data
    ): Collection {
        if ($this->dataControllerUpdateFields) {
            return $this->dataControllerUpdateFields;
        }

        $list = $this->getFieldDataFromEntity($data);

        $this->dataControllerUpdateFields = collect();
        foreach ($data->getControllerUpdate()->getFields() as $field) {
            if ($list->get($field->getField())) {
                $list[$field->getField()]->setVariable($field->getVariable());
                $list[$field->getField()]->setOriginalType($field->getOriginalType());
                $list[$field->getField()]->setTextFormatType($field->getTextFormatType());
                $list[$field->getField()]->setType($field->getType());
                $list[$field->getField()]->setRelation($field->isEntityEnable());
                $list[$field->getField()]->setRelationEntity($field->getEntity());
                $list[$field->getField()]->setMultiLanguage($field->isMultiLanguage());
                $list[$field->getField()]->setRequired($field->isRequired());
                $list[$field->getField()]->setNullable($field->isNullable());
                $this->dataControllerUpdateFields->push($list->get($field->getField()));
            }
        }

        return $this->dataControllerUpdateFields;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection|GeneratorServiceDataFieldData[]
     */
    protected function getFieldsForResponse(
        GeneratorServiceData $data
    ): Collection {
        if ($this->dataResponseFields) {
            return $this->dataResponseFields;
        }

        $this->dataResponseFields = collect();

        if (!$data->getResponse()->isEnable()) {
            return $this->dataResponseFields;
        }

        $list = $this->getFieldDataFromEntity($data);

        foreach ($data->getResponse()->getFields() as $field) {
            if ($list->get($field->getField())) {
                $list[$field->getField()]->setVariable($field->getVariable());
                $list[$field->getField()]->setMultiLanguage($field->isMultiLanguage());
                $this->dataResponseFields->push($list->get($field->getField()));
            }
        }

        return $this->dataResponseFields;
    }
}
