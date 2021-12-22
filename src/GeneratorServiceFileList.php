<?php

namespace ItDevgroup\LaravelGeneratorConfigurable;

use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileAvailable;
use ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFileRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class GeneratorServiceFileList
 * @package ItDevgroup\LaravelGeneratorConfigurable
 */
class GeneratorServiceFileList
{
    /**
     * @var array
     */
    public array $files = [];
    /**
     * @var bool
     */
    public bool $testMode = false;
    /**
     * @var string|null
     */
    public ?string $testFolder = null;

    /**
     * GeneratorServiceFileList constructor.
     */
    public function __construct()
    {
        $this->testMode = (bool)Config::get('generator.testMode');
        $this->testFolder = Config::get('generator.testFolder');

        if ($this->testMode) {
            $this->createFolderForTestFiles();
        }
    }

    /**
     * @param GeneratorServiceData $data
     * @return GeneratorServiceDataFileAvailable[][]
     */
    public function fileList(GeneratorServiceData $data): array
    {
        if (!$data->getEntity()->getName()) {
            return $this->files;
        }

        $this->getFilesEntity($data);
        $this->getFilesMigration($data);
        $this->getFilesSeeder($data);
        $this->getFilesResponse($data);
        $this->getFilesController($data);
        $this->getFilesRoute($data);
        $this->getFilesTest($data);
        $this->getFilesDoc($data);

        return $this->files;
    }

    /**
     * @param GeneratorServiceData $data
     * @return Collection|GeneratorServiceDataFileAvailable[][]
     */
    public function fileListWithKey(GeneratorServiceData $data): Collection
    {
        $list = collect();

        $loadFiles = $this->fileList($data);

        foreach ($loadFiles as $category => $fileList) {
            $tempList = collect();
            foreach ($fileList as $file) {
                $tempList->put($file->getPath(), $file);
            }
            $list->put($category, $tempList);
        }

        return $list;
    }

    /**
     * @param GeneratorServiceData $data
     * @param array $files
     * @return GeneratorServiceDataFileRequest[][]|Collection
     */
    public function fileListFromRequest(GeneratorServiceData $data, array $files): Collection
    {
        $list = collect();

        $loadFiles = $this->fileListWithKey($data);

        foreach ($files as $category => $fileList) {
            $tempList = collect();

            if (!$loadFiles->get($category)) {
                continue;
            }

            if ($category == GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION) {
                $list->put(
                    $category,
                    $this->fileListMigrationFromRequest(
                        $fileList,
                        $loadFiles->get($category)
                    )
                );
                continue;
            }

            foreach ($fileList as $file) {
                $file = collect($file);

                /** @var GeneratorServiceDataFileAvailable $fileConfig */
                $fileConfig = $loadFiles->get($category)->get($file->get('path'));
                if (!$fileConfig) {
                    continue;
                }

                $tempList->push(
                    GeneratorServiceDataFileRequest::register(
                        $file->get('path'),
                        $fileConfig->getTemplate(),
                        $file->get('create'),
                        $file->get('update'),
                        $file->get('modification'),
                        $fileConfig->getMode(),
                        $fileConfig->getFormat()
                    )
                );
            }
            $list->put($category, $tempList);
        }

        return $list;
    }

    /**
     * @param array $files
     * @param Collection $loadFiles
     * @return GeneratorServiceDataFileRequest[][]|Collection
     */
    public function fileListMigrationFromRequest(
        array $files,
        Collection $loadFiles
    ): Collection {
        $list = collect();

        $loadFiles = $loadFiles->values();

        foreach ($files as $index => $file) {
            $file = collect($file);

            /** @var GeneratorServiceDataFileAvailable $fileConfig */
            $fileConfig = null;
            if (!$index) {
                $fileConfig = $loadFiles->get(0);
            }

            if (!$fileConfig) {
                continue;
            }

            $list->push(
                GeneratorServiceDataFileRequest::register(
                    $file->get('path'),
                    $fileConfig->getTemplate(),
                    $file->get('create'),
                    $file->get('update'),
                    $file->get('modification'),
                    $fileConfig->getMode(),
                    $fileConfig->getFormat()
                )
            );
        }

        return $list;
    }

    /**
     * @param string|null $file
     * @return bool
     */
    public function checkWritableFile(?string $file): bool
    {
        if (file_exists($file)) {
            return is_writable($file);
        }

        $basePath = $this->testMode ? $this->testFolder : base_path();
        $filePath = strtr($file, [$basePath => '']);
        $explode = collect(explode('/', $filePath))->filter();
        $count = $explode->count();
        for ($i = 0; $i < $count; $i++) {
            $explode->pop();
            if (!$explode->count()) {
                break;
            }
            $fullPath = $this->getFullFilePath($explode->implode('/'));
            if (is_dir($fullPath)) {
                return is_writable($fullPath);
            }
            if ($explode->count() == 1) {
                return is_writable($this->testFolder);
            }
        }

        return false;
    }

    /**
     * @param string $type
     * @param string $file
     * @param string $template
     * @param bool $modification
     * @param bool $system
     * @param string|null $mode
     * @param string|null $format
     */
    public function addFile(
        string $type,
        string $file,
        string $template,
        bool $modification = false,
        bool $system = false,
        ?string $mode = null,
        ?string $format = null
    ): void {
        $this->files[$type][] = GeneratorServiceDataFileAvailable::register(
            $file,
            $template,
            file_exists($this->getFullFilePath($file)),
            $modification,
            $system,
            $this->checkWritableFile($this->getFullFilePath($file)),
            $mode,
            $format
        );
    }

    /**
     * @param string $file
     * @return string
     */
    public function getFullFilePath(string $file): string
    {
        if ($this->testMode) {
            return sprintf(
                '%s%s',
                $this->testFolder,
                $file
            );
        } else {
            return base_path($file);
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
     * @param string $type
     * @param GeneratorServiceData $data
     * @param array|null $files
     * @param string|null $context
     */
    public function getCustomFilesByList(
        string $type,
        GeneratorServiceData $data,
        ?array $files,
        ?string $context = null
    ): void {
        if (!is_array($files)) {
            return;
        }

        foreach ($files as $file) {
            $file = collect($file);
            $entityName = $data->getEntity()->getName();
            if ($type == GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC) {
                $entityName = Str::snake($data->getEntity()->getName());
            } elseif ($type == GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION) {
                $entityName = $data->getEntity()->getTable();
            }
            $file->put(
                GeneratorServiceInterface::CUSTOM_FILE_OUTPUT_FILE_KEY,
                strtr(
                    $file->get(GeneratorServiceInterface::CUSTOM_FILE_OUTPUT_FILE_KEY),
                    [
                        '%contextPath%' => $context ? $context . '/' : '',
                        '%context%' => $context,
                        '%migrationDate%' => Carbon::now()->format('Y_m_d_His'),
                        '%' => $entityName,
                        '%:snake%' => Str::snake($entityName),
                    ]
                )
            );
            $fileMode = $file->get(GeneratorServiceInterface::CUSTOM_FILE_MODE_KEY);
            $format = $file->get(GeneratorServiceInterface::CUSTOM_FILE_FORMAT_KEY);
            $modification = $fileMode == GeneratorServiceInterface::MODE_MODIFICATION;
            $system = $fileMode == GeneratorServiceInterface::MODE_SYSTEM;
            $this->addFile(
                $type,
                $file->get(GeneratorServiceInterface::CUSTOM_FILE_OUTPUT_FILE_KEY),
                $file->get(GeneratorServiceInterface::CUSTOM_FILE_TEMPLATE_KEY),
                $modification,
                $system,
                $fileMode,
                $format
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    public function getFilesEntity(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY);
        if (is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ENTITY,
                $data,
                $this->config($key)
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    public function getFilesMigration(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION);
        if ($data->getMigration()->isEnable() && is_array($this->config($key))) {
            $list = [$this->config($key)[0]];
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_MIGRATION,
                $data,
                $list
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    public function getFilesSeeder(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER);
        if ($data->getSeeder()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_SEEDER,
                $data,
                $this->config($key)
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    public function getFilesResponse(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE);
        if ($data->getResponse()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_RESPONSE,
                $data,
                $this->config($key)
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    public function getFilesController(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER);
        if (
            ($data->getControllerList()->isEnable()
                || $data->getControllerById()->isEnable()
                || $data->getControllerCreate()->isEnable()
                || $data->getControllerUpdate()->isEnable()
                || $data->getControllerDelete()->isEnable())
            && is_array($this->config($key))
        ) {
            $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER);
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key),
                $data->getConfig()->getContextController()
            );
        }

        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_LIST);
        if ($data->getControllerList()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key)
            );
        }

        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_BY_ID);
        if ($data->getControllerById()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key)
            );
        }

        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_CREATE);
        if ($data->getControllerCreate()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key)
            );
        }

        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_UPDATE);
        if ($data->getControllerUpdate()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key)
            );
        }

        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER_DELETE);
        if ($data->getControllerDelete()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_CONTROLLER,
                $data,
                $this->config($key)
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    private function getFilesRoute(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE);
        if ($data->getRoute()->isEnable() && $data->getRoute()->getFilename() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_ROUTE,
                $data,
                $this->config($key),
                $data->getRoute()->getFilename()
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    private function getFilesTest(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST);
        if ($data->getTest()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_TEST,
                $data,
                $this->config($key),
                $data->getConfig()->getContextTest()
            );
        }
    }

    /**
     * @param GeneratorServiceData $data
     */
    private function getFilesDoc(GeneratorServiceData $data): void
    {
        $key = $this->keyCustomFiles($data, GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC);
        if ($data->getApiDoc()->isEnable() && is_array($this->config($key))) {
            $this->getCustomFilesByList(
                GeneratorServiceInterface::CUSTOM_FILE_CONTEXT_API_DOC,
                $data,
                $this->config($key),
                $data->getConfig()->getContextApiDoc()
            );
        }
    }

    /**
     * @return void
     */
    private function createFolderForTestFiles(): void
    {
        Storage::disk(GeneratorServiceInterface::FILESYSTEM_DISK)
            ->makeDirectory($this->testFolder);
    }

    /**
     * @param GeneratorServiceData $data
     * @param string $context
     * @return string
     */
    private function keyCustomFiles(GeneratorServiceData $data, string $context): string
    {
        $setsKeyContext = sprintf(
            'generator.sets.%s.customFiles',
            $data->getConfig()->getSets()
        );

        if (
            $data->getConfig()->getSets()
            && $data->getConfig()->getSets() != GeneratorServiceInterface::SETS_DEFAULT_VALUE
            && Config::get($setsKeyContext)
        ) {
            return sprintf(
                'generator.sets.%s.customFiles.%s',
                $data->getConfig()->getSets(),
                $context
            );
        }

        return sprintf(
            'generator.customFiles.%s',
            $context
        );
    }
}
