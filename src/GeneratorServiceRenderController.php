<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerCreate;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataControllerUpdate;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;

/**
 * Class GeneratorServiceRenderController
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderController extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'useCommonForController' => $this->getUseCommonClassesForController($data),
            'useEntityForController' => $this->getUseEntityClassesForController($data),
            'useCommonForCreate' => $this->getUseCommonClassesForCreateCommand($data->getControllerCreate()),
            'useEntityForCreate' => $this->getUseEntityClassesForCreateCommand($data->getControllerCreate()),
            'useCommonForUpdate' => $this->getUseCommonClassesForUpdateCommand($data->getControllerUpdate()),
            'useEntityForUpdate' => $this->getUseEntityClassesForUpdateCommand($data->getControllerUpdate()),
            'entityFields' => $this->getFieldDataFromEntity($data),
            'filterFields' => $data->getFilter()->getFields(),
            'relationFields' => $this->getRelationFieldsFromEntity($data->getEntity()),
            'controllerCreateFields' => $this->getFieldsForControllerCreate($data),
            'controllerUpdateFields' => $this->getFieldsForControllerUpdate($data),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }

    /**
     * @param GeneratorServiceDataControllerCreate $controller
     * @return Collection
     */
    private function getUseCommonClassesForCreateCommand(
        GeneratorServiceDataControllerCreate $controller
    ): Collection {
        $use = collect();

        foreach ($controller->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        return $use;
    }

    /**
     * @param GeneratorServiceDataControllerCreate $controller
     * @return Collection
     */
    private function getUseEntityClassesForCreateCommand(
        GeneratorServiceDataControllerCreate $controller
    ): Collection {
        $use = collect();

        foreach ($controller->getFields() as $field) {
            if (!$field->isEntityEnable()) {
                continue;
            }

            $this->addUniqueValueInCollection($use, $field->getEntity());
        }

        return $use;
    }

    /**
     * @param GeneratorServiceDataControllerUpdate $controller
     * @return Collection
     */
    private function getUseCommonClassesForUpdateCommand(
        GeneratorServiceDataControllerUpdate $controller
    ): Collection {
        $use = collect();

        foreach ($controller->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        return $use;
    }

    /**
     * @param GeneratorServiceDataControllerUpdate $controller
     * @return Collection
     */
    private function getUseEntityClassesForUpdateCommand(
        GeneratorServiceDataControllerUpdate $controller
    ): Collection {
        $use = collect();

        foreach ($controller->getFields() as $field) {
            if (!$field->isEntityEnable()) {
                continue;
            }

            $this->addUniqueValueInCollection($use, $field->getEntity());
        }

        return $use;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection
     */
    private function getUseEntityClassesForController(
        GeneratorServiceData $data
    ): Collection {
        $use = collect();

        foreach ($data->getControllerCreate()->getFields() as $field) {
            if (!$field->isEntityEnable()) {
                continue;
            }

            $this->addUniqueValueInCollection($use, $field->getEntity());
        }

        foreach ($data->getControllerUpdate()->getFields() as $field) {
            if (!$field->isEntityEnable()) {
                continue;
            }

            $this->addUniqueValueInCollection($use, $field->getEntity());
        }

        return $use;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection
     */
    private function getUseCommonClassesForController(
        GeneratorServiceData $data
    ): Collection {
        $use = collect();

        foreach ($data->getControllerCreate()->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        foreach ($data->getControllerUpdate()->getFields() as $field) {
            $namespace = null;
            if ($field->getType() == 'Carbon') {
                $namespace = 'Carbon\Carbon';
            }

            $this->addUniqueValueInCollection($use, $namespace);
        }

        return $use;
    }
}
