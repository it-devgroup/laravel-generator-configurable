<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFile
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFile
{
    /**
     * @var string
     */
    private string $path;
    /**
     * @var string
     */
    private string $content;
    /**
     * @var bool
     */
    private bool $actionCreate = false;
    /**
     * @var bool
     */
    private bool $actionUpdate = false;
    /**
     * @var bool
     */
    private bool $actionModification = false;

    /**
     * @param string $path
     * @param string $content
     * @param bool $actionCreate
     * @param bool $actionUpdate
     * @param bool $actionModification
     * @return self
     */
    public static function register(
        string $path,
        string $content,
        bool $actionCreate,
        bool $actionUpdate,
        bool $actionModification
    ): self {
        $model = (new self());
        $model->path = $path;
        $model->content = $content;
        $model->actionCreate = $actionCreate;
        $model->actionUpdate = $actionUpdate;
        $model->actionModification = $actionModification;

        return $model;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isActionCreate(): bool
    {
        return $this->actionCreate;
    }

    /**
     * @return bool
     */
    public function isActionUpdate(): bool
    {
        return $this->actionUpdate;
    }

    /**
     * @return bool
     */
    public function isActionModification(): bool
    {
        return $this->actionModification;
    }
}
