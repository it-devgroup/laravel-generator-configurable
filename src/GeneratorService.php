<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * Class GeneratorService
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorService implements GeneratorServiceInterface
{
    /**
     * @var bool
     */
    private bool $testMode;
    /**
     * @var GeneratorServiceFileList
     */
    private GeneratorServiceFileList $generatorServiceFileList;
    /**
     * @var GeneratorServiceLoadData
     */
    private GeneratorServiceLoadData $generatorServiceLoadData;
    /**
     * @var GeneratorServiceRenderEntity
     */
    private GeneratorServiceRenderEntity $generatorServiceRenderEntity;
    /**
     * @var GeneratorServiceRenderController
     */
    private GeneratorServiceRenderController $generatorServiceRenderController;
    /**
     * @var GeneratorServiceRenderResponse
     */
    private GeneratorServiceRenderResponse $generatorServiceRenderResponse;
    /**
     * @var GeneratorServiceRenderSeeder
     */
    private GeneratorServiceRenderSeeder $generatorServiceRenderSeeder;
    /**
     * @var GeneratorServiceRenderTest
     */
    private GeneratorServiceRenderTest $generatorServiceRenderTest;
    /**
     * @var GeneratorServiceRenderRoute
     */
    private GeneratorServiceRenderRoute $generatorServiceRenderRoute;
    /**
     * @var GeneratorServiceRenderMigration
     */
    private GeneratorServiceRenderMigration $generatorServiceRenderMigration;
    /**
     * @var GeneratorServiceRenderApiDoc
     */
    private GeneratorServiceRenderApiDoc $generatorServiceRenderApiDoc;

    /**
     * GeneratorService constructor.
     * @param GeneratorServiceFileList $generatorServiceFileList
     * @param GeneratorServiceLoadData $generatorServiceLoadData
     * @param GeneratorServiceRenderEntity $generatorServiceRenderEntity
     * @param GeneratorServiceRenderController $generatorServiceRenderController
     * @param GeneratorServiceRenderResponse $generatorServiceRenderResponse
     * @param GeneratorServiceRenderSeeder $generatorServiceRenderSeeder
     * @param GeneratorServiceRenderTest $generatorServiceRenderTest
     * @param GeneratorServiceRenderRoute $generatorServiceRenderRoute
     * @param GeneratorServiceRenderMigration $generatorServiceRenderMigration
     * @param GeneratorServiceRenderApiDoc $generatorServiceRenderApiDoc
     */
    public function __construct(
        GeneratorServiceFileList $generatorServiceFileList,
        GeneratorServiceLoadData $generatorServiceLoadData,
        GeneratorServiceRenderEntity $generatorServiceRenderEntity,
        GeneratorServiceRenderController $generatorServiceRenderController,
        GeneratorServiceRenderResponse $generatorServiceRenderResponse,
        GeneratorServiceRenderSeeder $generatorServiceRenderSeeder,
        GeneratorServiceRenderTest $generatorServiceRenderTest,
        GeneratorServiceRenderRoute $generatorServiceRenderRoute,
        GeneratorServiceRenderMigration $generatorServiceRenderMigration,
        GeneratorServiceRenderApiDoc $generatorServiceRenderApiDoc
    ) {
        $this->testMode = Config::get('generator.testMode');
        $this->generatorServiceFileList = $generatorServiceFileList;
        $this->generatorServiceLoadData = $generatorServiceLoadData;
        $this->generatorServiceRenderEntity = $generatorServiceRenderEntity;
        $this->generatorServiceRenderController = $generatorServiceRenderController;
        $this->generatorServiceRenderResponse = $generatorServiceRenderResponse;
        $this->generatorServiceRenderSeeder = $generatorServiceRenderSeeder;
        $this->generatorServiceRenderTest = $generatorServiceRenderTest;
        $this->generatorServiceRenderRoute = $generatorServiceRenderRoute;
        $this->generatorServiceRenderMigration = $generatorServiceRenderMigration;
        $this->generatorServiceRenderApiDoc = $generatorServiceRenderApiDoc;
    }

    /**
     * @return array
     */
    public function setsList(): array
    {
        $sets = [];

        if (!Config::get('generator.defaultCustomFilesDisable')) {
            $sets[] = self::SETS_DEFAULT_VALUE;
        }

        if (!Config::get('generator.sets') || !is_array(Config::get('generator.sets'))) {
            return $sets;
        }

        foreach (Config::get('generator.sets') as $set => $data) {
            $sets[] = $set;
        }

        return $sets;
    }

    /**
     * @param array $data
     * @param bool $formatted
     * @return array
     */
    public function generateFileList(array $data, $formatted = false): array
    {
        $data = $this->generatorServiceLoadData->loadData($data);

        $fileCategories = $this->generatorServiceFileList->fileList($data);
        if (!$formatted) {
            return $fileCategories;
        }

        $return = [];
        foreach ($fileCategories as $category => $files) {
            if (!isset($return[$category])) {
                $return[$category] = [];
            }

            foreach ($files as $file) {
                $return[$category][] = [
                    'path' => $file->getPath(),
                    'available' => $file->isAvailable(),
                    'modification' => $file->isModification(),
                    'system' => $file->isSystem(),
                    'writable' => $file->isWritable(),
                ];
            }
        }

        return $return;
    }

    /**
     * @param array $data
     */
    public function generateFiles(array $data): void
    {
        $files = $data['files'];

        $data = $this->generatorServiceLoadData->loadData($data['data']);
        if (!$data->getEntity()->getName()) {
            return;
        }

        $fileFromRequest = $this->generatorServiceFileList->fileListFromRequest($data, $files);

        $this->clearTestFolder();

        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY)) {
            $this->generateFilesEntity(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER)) {
            $this->generateFilesController(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE)) {
            $this->generateFilesResponse(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER)) {
            $this->generateFilesSeeder(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST)) {
            $this->generateFilesTest(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE)) {
            $this->generateFilesRoute(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION)) {
            $this->generateFilesMigration(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION)
            );
        }
        if ($fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC)) {
            $this->generateFilesApiDoc(
                $data,
                $fileFromRequest->get(GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC)
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesEntity(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderEntity->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesController(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderController->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesResponse(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderResponse->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesSeeder(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderSeeder->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesTest(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderTest->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesRoute(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderRoute->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesMigration(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderMigration->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @param GeneratorServiceData $data
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function generateFilesApiDoc(GeneratorServiceData $data, Collection $files): void
    {
        $this->generatorServiceRenderApiDoc->renderFiles($data, $files);

        $this->saveFiles($files);
    }

    /**
     * @return void
     */
    private function clearTestFolder(): void
    {
        if (!$this->testMode) {
            return;
        }

        $files = Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
            ->allFiles();
        Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
            ->delete($files);
        $directories = Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
            ->allDirectories();
        foreach ($directories as $directory) {
            Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
                ->deleteDirectory($directory);
        }
    }

    /**
     * @param Collection|GeneratorServiceDataFileRequest[] $files
     */
    private function saveFiles(Collection $files): void
    {
        foreach ($files as $file) {
            if ($file->isActionCreate() || $file->isActionUpdate()) {
                Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
                    ->put($file->getPath(), $file->getContent());
            } elseif ($file->isActionModification()) {
                if ($this->testMode) {
                    Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
                        ->put($file->getPath(), $file->getContent());
                } else {
                    Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
                        ->append($file->getPath(), $file->getContent());
                }
            }
        }
    }
}
