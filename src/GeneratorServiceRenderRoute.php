<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class GeneratorServiceRenderRoute
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderRoute extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'entityNameRouteAlias' => Str::of(Str::snake($data->getEntity()->getName()))->replace('_', '.'),
            'prefix' => $data->getRoute()->getPrefix(),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }
}
