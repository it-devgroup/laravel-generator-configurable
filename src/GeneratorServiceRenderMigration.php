<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;

/**
 * Class GeneratorServiceRenderMigration
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceRenderMigration extends GeneratorServiceRenderAbstract
{
    /**
     * @inheritDoc
     */
    protected string $context = GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION;

    /**
     * @param GeneratorServiceData $data
     * @param GeneratorServiceDataFileRequest[]|Collection $files
     */
    public function renderFiles(GeneratorServiceData $data, Collection $files): void
    {
        $data = [
            'data' => $data,
            'entityName' => $data->getEntity()->getName(),
            'table' => $data->getEntity()->getTable(),
            'migrationFields' => $data->getMigration()->getFields(),
        ];

        $this->addExtraVariables($data);

        $files->map(
            function (GeneratorServiceDataFileRequest $file) use ($data) {
                $file->setContent($this->getContent($data, $file));
            }
        );
    }
}
