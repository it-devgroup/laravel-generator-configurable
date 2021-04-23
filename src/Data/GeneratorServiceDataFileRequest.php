<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFileRequest
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFileRequest
{
    /**
     * @var string
     */
    private string $path;
    /**
     * @var string
     */
    private string $template;
    /**
     * @var string|null
     */
    private ?string $content = null;
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
     * @var string|null
     */
    private ?string $mode;
    /**
     * @var string|null
     */
    private ?string $format;

    /**
     * @param string $path
     * @param string $template
     * @param bool $actionCreate
     * @param bool $actionUpdate
     * @param bool $actionModification
     * @param string|null $mode
     * @param string|null $format
     * @return self
     */
    public static function register(
        string $path,
        string $template,
        bool $actionCreate,
        bool $actionUpdate,
        bool $actionModification,
        ?string $mode,
        ?string $format
    ): self {
        $model = (new self());
        $model->path = $path;
        $model->template = $template;
        $model->actionCreate = $actionCreate;
        $model->actionUpdate = $actionUpdate;
        $model->actionModification = $actionModification;
        $model->mode = $mode;
        $model->format = $format;

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
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
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

    /**
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }
}
