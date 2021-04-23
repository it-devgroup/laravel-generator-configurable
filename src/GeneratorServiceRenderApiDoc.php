<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class GeneratorServiceRenderApiDoc
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderApiDoc extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $entityNameText = Str::snake($data->getEntity()->getName());
        $entityNameText = Str::ucfirst($entityNameText);
        $entityNameText = Str::of($entityNameText)->replace('_', ' ');

        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'entityNameText' => $entityNameText,
            'entityFields' => $this->getFieldDataFromEntity($data),
            'filterFields' => $data->getFilter()->getFields(),
            'responseFields' => $this->getFieldsForResponse($data),
            'controllerCreateFields' => $this->getFieldsForControllerCreate($data),
            'controllerUpdateFields' => $this->getFieldsForControllerUpdate($data),
            'sortableFields' => $this->getSortableFieldsFromEntity($data),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }
}
