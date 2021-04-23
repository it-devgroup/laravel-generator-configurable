<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFileAvailable
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFileAvailable
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
     * @var bool
     */
    private bool $available;
    /**
     * @var bool
     */
    private bool $modification;
    /**
     * @var bool
     */
    private bool $system;
    /**
     * @var bool
     */
    private bool $writable;
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
     * @param bool $available
     * @param bool $modification
     * @param bool $system
     * @param bool $writable
     * @param string|null $mode
     * @param string|null $format
     * @return self
     */
    public static function register(
        string $path,
        string $template,
        bool $available,
        bool $modification,
        bool $system,
        bool $writable,
        ?string $mode,
        ?string $format
    ): self {
        $model = (new self());
        $model->path = $path;
        $model->template = $template;
        $model->available = $available;
        $model->modification = $modification;
        $model->system = $system;
        $model->writable = $writable;
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
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * @return bool
     */
    public function isModification(): bool
    {
        return $this->modification;
    }

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        return $this->system;
    }

    /**
     * @return bool
     */
    public function isWritable(): bool
    {
        return $this->writable;
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
