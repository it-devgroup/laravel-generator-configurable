<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntity;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class GeneratorServiceRenderEntity
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderEntity extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'entityTable' => $data->getEntity()->getTable(),
            'entityFields' => $this->getFieldDataFromEntity($data),
            'entityFieldsMultiLanguage' => $this->getEntityFieldsMultiLanguage($data->getEntity()),
            'entityFieldsDateTime' => $this->getEntityFieldsDateTime($data->getEntity()),
            'entityFieldsCasts' => $this->getEntityFieldsCasts($data->getEntity()),
            'entityFieldDeletedAt' => $data->getEntity()->getDeletedAt(),
            'entityFieldCreatedAt' => $data->getEntity()->getCreatedAt(),
            'entityFieldUpdatedAt' => $data->getEntity()->getUpdatedAt(),
            'enableMultiLanguage' => $this->checkEnableEntityMultiLanguage($data->getEntity()),
            'useCommonForEntity' => $this->getEntityUseCommonClasses($data->getEntity()),
            'useEntityForEntity' => $this->getEntityUseCustomClasses($data->getEntity()),
            'filterFields' => $data->getFilter()->getFields(),
            'useCommonForFilter' => $this->getFilterUseCommonClasses($data->getFilter()),
            'relationFields' => $this->getRelationFieldsFromEntity($data->getEntity()),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return bool
     */
    private function checkEnableEntityMultiLanguage(GeneratorServiceDataEntity $entity): bool
    {
        foreach ($entity->getFields() as $field) {
            if ($field->isMultiLanguage()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return Collection
     */
    private function getEntityFieldsMultiLanguage(GeneratorServiceDataEntity $entity): Collection
    {
        $fields = collect();

        foreach ($entity->getFields() as $field) {
            if ($field->isMultiLanguage()) {
                $fields->push($field->getField());
            }
        }

        return $fields;
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return Collection
     */
    private function getEntityFieldsDateTime(GeneratorServiceDataEntity $entity): Collection
    {
        $fields = collect();

        foreach ($entity->getFields() as $field) {
            if ($field->getType() == 'Carbon') {
                $fields->push($field->getField());
            }
        }

        if ($entity->getDeletedAt()) {
            $fields->push(GeneratorServiceInterface::FIELD_NAME_DELETED_AT);
        }

        if ($entity->getCreatedAt()) {
            $fields->push(GeneratorServiceInterface::FIELD_NAME_CREATED_AT);
        }

        if ($entity->getUpdatedAt()) {
            $fields->push(GeneratorServiceInterface::FIELD_NAME_UPDATED_AT);
        }

        return $fields;
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return Collection
     */
    private function getEntityFieldsCasts(GeneratorServiceDataEntity $entity): Collection
    {
        $fields = collect();

        $relationFields = $this->getRelationFieldsFromEntity($entity, true);

        foreach ($entity->getFields() as $field) {
            if ($field->isMultiLanguage() || $relationFields->get($field->getField())) {
                continue;
            }

            switch ($field->getType()) {
                case 'int':
                case 'integer':
                    $fields->put($field->getField(), 'int');
                    break;
                case 'float':
                    $fields->put($field->getField(), 'float');
                    break;
                case 'bool':
                case 'boolean':
                    $fields->put($field->getField(), 'bool');
                    break;
                case 'array':
                    $fields->put($field->getField(), 'array');
                    break;
            }
        }

        return $fields;
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return Collection
     */
    private function getEntityUseCommonClasses(GeneratorServiceDataEntity $entity): Collection
    {
        $use = collect();

        foreach ($entity->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        foreach ($entity->getRelations() as $relation) {
            $namespace = Str::ucfirst($relation->getType());
            $namespace = sprintf(
                'Illuminate\Database\Eloquent\Relations\%s',
                $namespace
            );

            $this->addUniqueValueInCollection($use, $namespace);
        }

        return $use;
    }

    /**
     * @param GeneratorServiceDataEntity $entity
     * @return Collection
     */
    private function getEntityUseCustomClasses(GeneratorServiceDataEntity $entity): Collection
    {
        $use = collect();

        foreach ($entity->getRelations() as $relation) {
            $this->addUniqueValueInCollection($use, $relation->getEntity());
        }

        return $use;
    }

    /**
     * @param GeneratorServiceDataFilter $filter
     * @return Collection
     */
    private function getFilterUseCommonClasses(GeneratorServiceDataFilter $filter): Collection
    {
        $use = collect();

        foreach ($filter->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        return $use;
    }
}
