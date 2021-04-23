<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;

/**
 * Class GeneratorServiceRenderResponse
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderResponse extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE;

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
            'responseFields' => $this->getFieldsForResponse($data),
            'relationFields' => $this->getRelationFieldsFromEntity($data->getEntity()),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }
}
