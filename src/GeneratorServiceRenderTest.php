<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class GeneratorServiceRenderTest
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderTest extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'entityFields' => $this->getFieldDataFromEntity($data),
            'entityNameRouteAlias' => Str::of(Str::snake($data->getEntity()->getName()))->replace('_', '.'),
            'context' => $data->getConfig()->getContextTest(),
            'contextLower' => Str::camel($data->getConfig()->getContextTest()),
            'relationFields' => $this->getRelationFieldsFromEntity($data->getEntity()),
            'controllerCreateFields' => $this->getFieldsForControllerCreate($data),
            'controllerUpdateFields' => $this->getFieldsForControllerUpdate($data),
            'responseFields' => $this->getFieldsForResponse($data),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }
}
